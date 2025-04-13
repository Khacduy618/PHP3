<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;        // Import Str facade
use Illuminate\Support\Facades\Auth; // Import Auth facade

class AdminNewsController extends Controller
{
    public function index()
    {
        $page_title = "NEWS - Danh sách tin tức";
        $title = "Danh sách tin tức";
        $news = DB::table('news')
            ->join('users', 'news.user_id', '=', 'users.id')
            ->join('categories', 'news.category_id', '=', 'categories.id')
            ->select('news.*', 'users.name as author', 'categories.name as category_name')->orderBy('created_at', 'desc')
            ->get();

        return view('admin.news.list', compact('news', 'title', 'page_title'));
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
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
        ]);

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

        return redirect()->route('admin.news.list')->with('success', 'Tin tức đã được thêm thành công!'); // Redirect to list view
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {

        $news = DB::table('news')->where('slug', $slug)->first();
        $title = $news->title;
        $page_title = 'NEWS - ' . $title;
        return view('client.details', compact('news', 'page_title'));
    }

    /**
     * Display news by category.
     */
    public function showByCategory(string $slug)
    {
        $category = DB::table('categories')->where('slug', $slug)->first();
        $id = $category->id;

        $news = DB::table('news')
            ->join('users', 'news.user_id', '=', 'users.id')
            ->join('categories', 'news.category_id', '=', 'categories.id')
            ->select('news.*', 'users.name as author', 'categories.name as category_name')
            ->where('news.status', 'published')
            ->whereIn('news.category_id', function ($query) use ($id) {
                $query->select('id')
                    ->from('categories')
                    ->where('parent_id', $id);
            })
            ->get();

        $page_title = 'NEWS - ' . $category->name;

        return view('client.news_byCategory', compact('news', 'page_title', 'category'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $page_title = 'NEWS - Chỉnh sửa tin tức';
        $title = 'Chỉnh sửa tin tức';

        $news = DB::table('news')->where('slug', $slug)->first();
        $categories = DB::table('categories')->limit(6)->get();
        return view('admin.news.edit', compact('news', 'categories', 'title', 'page_title'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        $id = DB::table('news')->where('slug', $slug)->value('id');
        $newsItem = News::find($id);

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
        ]);

        // Get the specific fields we want to update directly from the request
        $data = $request->only(['title', 'category_id', 'content', 'status']);

        // Convert tags string to array, then encode as JSON with unescaped unicode
        $data['tags'] = $request->filled('tags') ? json_encode(array_map('trim', explode(',', $request->tags)), JSON_UNESCAPED_UNICODE) : null;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($newsItem->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($newsItem->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($newsItem->image);
            }
            // Store new image
            $data['image'] = $request->file('image')->store('news_images', 'public');
        }

        // Regenerate slug if title changed
        if ($request->title !== $newsItem->title) {
            $data['slug'] = Str::slug($request->title);
        }

        // Regenerate summary if content changed OR if summary was provided
        if ($request->filled('summary') || $request->content !== $newsItem->content) {
            $data['summary'] = $request->filled('summary') ? $request->summary : Str::limit(strip_tags($request->content), 150);
        }

        // Handle boolean flags (use boolean helper for checkboxes) - Ensure they are always present
        $data['is_hot'] = $request->boolean('is_hot');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_trending'] = $request->boolean('is_trending');

        // Update the news item
        $newsItem->update($data);

        // Redirect back to the edit form or list view
        return redirect()->route('admin.news.edit', $newsItem->slug)->with('success', 'Tin tức đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
