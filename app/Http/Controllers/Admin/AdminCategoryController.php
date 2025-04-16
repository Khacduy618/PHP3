<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Support\Str;        // Import Str facade (for slug generation)
use Illuminate\Validation\Rule; // Import Rule

class AdminCategoryController extends Controller
{

    public function index(Request $request) // Inject Request
    {
        $page_title = "NEWS - Danh sách loại tin";
        $title = "Danh sách loại tin";

        // Get sorting parameters from request, set defaults
        $sortBy = $request->query('sort_by', 'created_at'); // Default sort by creation date
        $sortDir = $request->query('sort_dir', 'asc'); // Default sort direction

        // Validate sortable columns
        $sortableColumns = ['id', 'name', 'created_at'];
        if (!in_array($sortBy, $sortableColumns)) {
            $sortBy = 'created_at'; // Fallback to default
        }
        if (!in_array($sortDir, ['asc', 'desc'])) {
            $sortDir = 'desc'; // Fallback to default
        }

        // Build the query
        $categoryQuery = Category::withTrashed(); // Include soft-deleted

        // Apply search filter if present
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $categoryQuery->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        // Apply sorting
        $categoryQuery->orderByRaw('deleted_at IS NULL DESC'); // Keep active/deleted sorting first
        $categoryQuery->orderBy($sortBy, $sortDir); // Apply user sorting

        // Paginate results
        $categories = $categoryQuery->paginate(10)->appends($request->query()); // Append query string

        return view("admin.category.list", compact("page_title", "title", "categories", 'sortBy', 'sortDir')); // Pass sorting params

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_title = "NEWS - Thêm loại tin";
        $title = "Thêm loại tin";
        return view("admin.category.add", compact("page_title", "title"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories,name', // Added unique rule
            'slug' => 'max:255',
            'description' => 'required',
            'parent_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:Hiện,Ẩn', // Added status validation
        ]);

        // The unique rule handles the name check, so the manual check below is removed.

        // Kiểm tra xem slug đã tồn tại chưa;
        // Auto-generate slug if not provided or ensure uniqueness
        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);
        $originalSlug = $slug;
        $count = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        // Create category using mass assignment
        Category::create([
            'name' => $request->name,
            'slug' => $slug, // Use generated slug
            'description' => $request->description,
            'parent_id' => $request->parent_id, // Will be null if "None" selected
            'status' => $request->status,
            'user_id' => Auth::id(), // Set the creator ID
        ]);

        return redirect()->route('admin.category.list')->with('success', 'Thêm loại tin thành công');
    }

    /**
     * Return all categories as JSON for API requests.
     */
    public function apiIndex()
    {
        $categories = Category::withTrashed()->get(); // Fetch all categories, including soft-deleted
        return response()->json($categories);
    }

    public function hide(Request $request, string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail(); // Use Eloquent
        $category->status = 'Ẩn'; // Directly set status
        $category->save();

        return redirect()->route('admin.category.list')->with('success', 'Ẩn loại tin thành công');
    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail(); // Use Eloquent
        $category->status = 'Hiện'; // Directly set status
        $category->save();

        return redirect()->route('admin.category.list')->with('success', 'Hiển thị loại tin thành công');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        // Tìm danh mục theo slug
        $category = Category::where('slug', $slug)->firstOrFail(); // Use Eloquent

        $page_title = "NEWS - Sửa loại tin";
        $title = "Sửa loại tin";
        // Fetch parent categories for the dropdown (excluding the current one)
        $menuCategories = Category::whereNull('parent_id')->where('id', '!=', $category->id)->get();

        return view("admin.category.edit", compact("page_title", "title", "category", "menuCategories"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        // Find category, including soft-deleted ones for restore
        $category = Category::withTrashed()->where('slug', $slug)->firstOrFail(); // Re-add withTrashed()

        // Handle Restore Action first
        if ($request->has('restore')) {
            $category->restore();
            return redirect()->route('admin.category.list')->with('success', 'Danh mục đã được khôi phục thành công!');
        }

        // Proceed with regular update validation and logic
        $request->validate([
            'name' => 'required|max:255',
            'slug' => ['required', 'max:255', Rule::unique('categories')->ignore($category->id)], // Use Rule for uniqueness check
            'description' => 'required',
            'parent_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:Hiện,Ẩn',
        ]);

        // Prepare data for update
        $data = $request->only(['name', 'description', 'parent_id', 'status']);

        // Regenerate slug only if name changed
        if ($request->name !== $category->name) {
            $newSlug = Str::slug($request->name);
            $originalSlug = $newSlug;
            $count = 1;
            // Ensure uniqueness, excluding the current category ID
            while (Category::where('slug', $newSlug)->where('id', '!=', $category->id)->exists()) {
                $newSlug = $originalSlug . '-' . $count++;
            }
            $data['slug'] = $newSlug;
        } elseif ($request->slug !== $category->slug) {
            // If name didn't change, but slug did, use the provided slug (validation already checked uniqueness)
            $data['slug'] = $request->slug;
        }
        // If neither name nor slug changed, slug remains the same


        // Update using mass assignment
        $category->update($data);

        return redirect()->route('admin.category.list')->with('success', 'Cập nhật loại tin thành công');
    }

    /**
     * Remove the specified resource from storage (permanent delete).
     */
    public function destroy(string $slug)
    {
        // Find the category by slug
        $category = Category::where('slug', $slug)->firstOrFail();

        // TODO: Add logic here to handle child categories or related news if necessary
        // For example, prevent deletion if it has children, or reassign news items.
        // For now, we'll just soft delete the category.

        // Set status to 'Hidden' before soft deleting
        $category->status = 'Ẩn';
        $category->save();

        // Soft delete the category
        $category->delete(); // This performs a soft delete because of the trait

        return redirect()->route('admin.category.list')->with('success', 'Danh mục đã được chuyển vào thùng rác.');
    }
}
