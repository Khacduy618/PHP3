<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Category;
use Illuminate\Support\Facades\Storage; // Import Storage facade

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;        // Import Str facade
use Illuminate\Support\Facades\Auth; // Import Auth facade
use App\Mail\NewsCreatedNotification;
use App\Models\Subscriber;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AdminNewsController extends Controller
{
    public function index(Request $request) // Inject Request
    {
        $page_title = "NEWS - Danh sách tin tức";
        $title = "Danh sách tin tức";

        // Get sorting parameters from request, set defaults
        $sortBy = $request->query('sort_by', 'created_at'); // Default sort by creation date
        $sortDir = $request->query('sort_dir', 'desc'); // Default sort direction

        // Validate sortable columns
        $sortableColumns = ['id', 'title', 'created_at'];
        if (!in_array($sortBy, $sortableColumns)) {
            $sortBy = 'created_at'; // Fallback to default if invalid column provided
        }
        if (!in_array($sortDir, ['asc', 'desc'])) {
            $sortDir = 'desc'; // Fallback to default direction
        }

        // Fetch categories for the filter dropdown (active ones, with children)
        $categoriesForFilter = Category::where('status', 'Hiện')
            ->whereNull('parent_id') // Get top-level categories
            ->with('children') // Eager load children
            ->orderBy('name', 'asc')
            ->get();

        // Build the query
        $newsQuery = News::with(['user', 'category']) // Eager load relationships
            ->withTrashed(); // Include soft-deleted news

        // Apply search filter if present
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $newsQuery->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('summary', 'like', '%' . $searchTerm . '%')
                    ->orWhere('content', 'like', '%' . $searchTerm . '%');
            });
        }

        // Apply category filter if present
        if ($request->has('category_id') && $request->category_id != '') {
            $categoryId = $request->category_id;

            // Get the selected category
            $category = Category::find($categoryId);

            if ($category && $category->children->isNotEmpty()) {
                // Get all child category IDs
                $childCategoryIds = $category->children->pluck('id')->toArray();

                // Add the parent category ID to the array
                $categoryIds = array_merge([$categoryId], $childCategoryIds);

                // Modify the query to include news from the selected category and all its children
                $newsQuery->whereIn('category_id', $categoryIds);
            } else {
                // If no children, filter by the selected category ID
                $newsQuery->where('category_id', $categoryId);
            }
        }

        // Apply status filter
        if ($request->has('status') && $request->status != '') {
            $newsQuery->where('status', $request->status);
        }

        // Apply deleted status filter
        if ($request->has('deleted') && $request->deleted != '') {
            if ($request->deleted == 'true') {
                $newsQuery->onlyTrashed();
            } elseif ($request->deleted == 'false') {
                $newsQuery->whereNull('deleted_at');
            }
        }

        // Apply sorting
        // Always sort by deleted_at status first to keep active items on top when sorting other columns
        $newsQuery->orderByRaw('deleted_at IS NULL DESC');

        // Apply user-requested sorting
        $newsQuery->orderBy($sortBy, $sortDir);

        // Paginate results
        $news = $newsQuery->paginate(10)->appends([
            'search' => $request->query('search'),
            'category_id' => $request->query('category_id'),
            'status' => $request->query('status'),
            'deleted' => $request->query('deleted'),
            'sort_by' => $request->query('sort_by'),
            'sort_dir' => $request->query('sort_dir'),
        ]);

        // Note: The view 'admin.news.list' will need to be adjusted
        // to access related data via Eloquent relationships (e.g., $item->user->name, $item->category->name)
        // instead of the joined aliases (author, category_name).

        return view('admin.news.list', compact('news', 'title', 'page_title', 'sortBy', 'sortDir', 'categoriesForFilter')); // Pass categories and sorting params
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_title = 'NEWS - Thêm tin tức';
        $title = 'Thêm tin tức';
        $categories = Category::query()->whereNull('parent_id')->get();
        return view('admin.news.add', compact('categories', 'title', 'page_title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:news,title',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        // Check if the title already exists, excluding the current news item if it's an update
        $titleExists = News::where('title', $request->title)
            ->exists();

        if ($titleExists) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'title' => ['The title has already been taken.'],
            ]);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news_images', 'public');
        }

        News::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'content' => $request->content,
            'image' => $imagePath,
            'status' => $request->status,
            'user_id' => Auth::id(), // Set the author ID
            'slug' => Str::slug($request->title), // Generate slug
            'summary' => $request->filled('summary') ? $request->summary : Str::limit(strip_tags($request->content), 150),
            // Set defaults for fields not in the form
            'views' => 0,
            // Convert tags string to array, then encode as JSON with unescaped unicode
            'tags' => $request->filled('tags') ? json_encode(array_map('trim', explode(',', $request->tags)), JSON_UNESCAPED_UNICODE) : null,
            'is_hot' => $request->boolean('is_hot'),
            'is_featured' => $request->boolean('is_featured'),
            'is_trending' => $request->boolean('is_trending'),
        ]);

        $news = News::latest()->first();

        if ($request->status === 'published') {
            $subscribers = Subscriber::all();

            foreach ($subscribers as $subscriber) {
                try {
                    $mailTo = Mail::to($subscriber->email);
                    Log::info('Sending email to: ' . $subscriber->email);
                    $result = $mailTo->send(new NewsCreatedNotification($news, $subscriber));
                    Log::info('Email sent to: ' . $subscriber->email . ' - Result: ' . ($result === null ? 'Success' : 'Failure'));
                } catch (\Exception $e) {
                    Log::error('Failed to send email to: ' . $subscriber->email . ' - ' . $e->getMessage());
                }
            }
        }

        return redirect()->route('admin.news.list')->with('success', 'Tin tức đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $news = News::where('slug', $slug)->first();
        $title = $news->title;
        $page_title = 'NEWS - ' . $title;
        return view('client.details', compact('news', 'page_title'));
    }


    public function edit(string $slug)
    {
        $page_title = 'NEWS - Chỉnh sửa tin tức';
        $title = 'Chỉnh sửa tin tức';

        $news = News::where('slug', $slug)->first();
        $categories = Category::limit(6)->get();
        return view('admin.news.edit', compact('news', 'categories', 'title', 'page_title'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        // Find news item, including soft-deleted ones for restore
        $newsItem = News::withTrashed()->where('slug', $slug)->firstOrFail(); // Re-add withTrashed()

        // Handle Restore Action first
        if ($request->has('restore')) {
            $newsItem->status = 'draft';
            $newsItem->save();
            $newsItem->restore();
            return redirect()->route('admin.news.list')->with('success', 'Tin tức đã được khôi phục thành công!');
        }

        // Proceed with regular update validation and logic
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image is optional on update
            'status' => 'required|in:draft,published',
            // Add validation for other fields if they are editable (tags, flags, etc.)
            'tags' => 'nullable|string|max:255',
            'is_hot' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'is_trending' => 'nullable|boolean',
            // Slug validation will be added dynamically below
        ]);

        // Prepare data for update
        $data = $request->only(['title', 'category_id', 'content', 'status', 'summary']); // Include summary if provided

        // --- Slug Handling ---
        $newSlug = $newsItem->slug; // Default to existing slug
        if ($request->title !== $newsItem->title) {
            $newSlug = Str::slug($request->title); // Generate potential new slug
        }


        // If validation passed, add the slug to the data array
        $data['slug'] = $newSlug;
        // --- End Slug Handling ---


        // Convert tags string to array, then encode as JSON with unescaped unicode
        $data['tags'] = $request->filled('tags') ? json_encode(array_map('trim', explode(',', $request->tags)), JSON_UNESCAPED_UNICODE) : null;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($newsItem->image && Storage::disk('public')->exists($newsItem->image)) {
                Storage::disk('public')->delete($newsItem->image);
            }
            // Store new image
            $data['image'] = $request->file('image')->store('news_images', 'public');
        }

        // Regenerate summary only if content changed AND summary was NOT provided
        if (!$request->filled('summary') && $request->content !== $newsItem->content) {
            $data['summary'] = Str::limit(strip_tags($request->content), 150);
        }
        // If summary was provided in the request, it's already in $data

        // Handle boolean flags (use boolean helper for checkboxes) - Ensure they are always present
        $data['is_hot'] = $request->boolean('is_hot');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_trending'] = $request->boolean('is_trending');

        // Update the news item
        $newsItem->update($data);

        // Redirect back to the edit form or list view
        return redirect()->route('admin.news.list', $newsItem->slug)->with('success', 'Tin tức đã được cập nhật thành công!');
    }


    public function destroy(string $slug) // Use slug for consistency
    {
        // Find the newsItem by slug
        $newsItem = News::where('slug', $slug)->firstOrFail();

        // Set status to 'archived' before soft deleting
        $newsItem->status = 'archived'; // Assuming 'archived' is a valid status
        $newsItem->save();

        // Soft delete the newsItem
        $newsItem->delete(); // This performs a soft delete because of the trait

        return redirect()->route('admin.news.list')->with('success', 'Tin tức đã được chuyển vào thùng rác.');
    }

    /**
     * Handle image upload from CKEditor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ckeditorUpload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            // Store the file in public/storage/uploads (ensure 'uploads' directory exists and is linked)
            $request->file('upload')->storeAs('public/uploads', $fileName);

            // Generate the URL for the uploaded file
            $url = asset('storage/uploads/' . $fileName);

            // Return JSON response expected by CKEditor SimpleUploadAdapter
            return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
        }

        // Return error response if upload failed
        return response()->json(['uploaded' => 0, 'error' => ['message' => 'Upload failed']]);
    }
}
