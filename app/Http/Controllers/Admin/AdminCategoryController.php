<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Support\Str;        // Import Str facade (for slug generation)

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page_title = "NEWS - Danh sách loại tin";
        $title = "Danh sách loại tin";
        $categories = Category::all();
        return view("admin.category.list", compact("page_title", "title", "categories"));

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
            'name' => 'required|max:255',
            'slug' => 'required|max:255',
            'description' => 'required',
            'parent_id' => 'nullable|exists:categories,id',

        ]);


        // Kiểm tra xem tên đã tồn tại chưa
        if (Category::where('name', $request->name)->exists()) {
            return redirect()->back()->with('error', 'Tên danh mục đã tồn tại');
        }

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

    public function hide(Request $request, string $slug)
    {
        $id = DB::table('categories')->where('slug', $slug)->value('id');
        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('admin.category.list')->with('error', 'Danh mục không tồn tại');
        }

        $category->status = $request->status;
        $category->save();

        return redirect()->route('admin.category.list')->with('success', 'Ẩn loại tin thành công');
    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $slug)
    {
        $id = DB::table('categories')->where('slug', $slug)->value('id');
        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('admin.category.list')->with('error', 'Danh mục không tồn tại');
        }

        $category->status = $request->status;
        $category->save();

        return redirect()->route('admin.category.list')->with('success', 'Hiển thị loại tin thành công');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {

        // Lấy id
        $id = DB::table('categories')->where('slug', $slug)->value('id');
        // Tìm danh mục theo slug
        $category = Category::find($id);

        // Kiểm tra xem danh mục có tồn tại không
        if (!$category) {
            return redirect()->route('admin.category.list')->with('error', 'Danh mục không tồn tại');
        }
        // dd($category);
        $page_title = "NEWS - Sửa loại tin";
        $title = "Sửa loại tin";
        return view("admin.category.edit", compact("page_title", "title", "category"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255',
            'description' => 'required',
            'parent_id' => 'nullable|exists:categories,id',
        ]);
        $id = DB::table('categories')->where('slug', $slug)->value('id');
        // Kiểm tra xem danh mục có tồn tại không
        $category = Category::find($id);
        if (!$category) {
            return redirect()->route('admin.category.list')->with('error', 'Danh mục không tồn tại');
        }

        // Kiểm tra xem tên đã tồn tại chưa (ngoại trừ danh mục hiện tại)
        if (Category::where('name', $request->name)->where('id', '!=', $id)->exists()) {
            return redirect()->back()->with('error', 'Tên danh mục đã tồn tại');
        }

        // Kiểm tra xem slug đã tồn tại chưa (ngoại trừ danh mục hiện tại)
        if (Category::where('slug', $request->slug)->where('id', '!=', $id)->exists()) {
            return redirect()->back()->with('error', 'Slug đã tồn tại');
        }

        // Prepare data for update
        $data = $request->only(['name', 'description', 'parent_id', 'status']);

        // Regenerate slug only if name changed
        if ($request->name !== $category->name) {
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $count = 1;
            // Ensure uniqueness, excluding the current category ID
            while (Category::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $data['slug'] = $slug;
        } else {
            // Ensure the submitted slug is unique if it wasn't auto-generated from name
            if ($request->slug !== $category->slug && Category::where('slug', $request->slug)->where('id', '!=', $id)->exists()) {
                return redirect()->back()->with('error', 'Slug đã tồn tại');
            }
            // Only update slug if it was provided and different (and unique check passed)
            if ($request->filled('slug') && $request->slug !== $category->slug) {
                $data['slug'] = $request->slug;
            }
        }


        // Update using mass assignment
        $category->update($data);

        return redirect()->route('admin.category.list')->with('success', 'Cập nhật loại tin thành công');
    }
}
