<?php

use App\Http\Controllers\Admin\AdminNewsController;
use App\Http\Controllers\Client\CategoryController; // Added CategoryController import
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\NewsController;
use App\Http\Controllers\Client\CommentController; // Import CommentController
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminUserController; // Import AdminUserController
use Illuminate\Support\Facades\Route;

// Updated home route to use HomeController
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route for displaying a single news item (using slug)
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');

// Route for displaying news filtered by tag
Route::get('/tag/{tag}', [NewsController::class, 'showByTag'])->name('news.by_tag'); // Assuming showByTag method exists

// Route for displaying news filtered by category slug (child category)
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');

// Route for displaying news filtered by parent category slug
Route::get('/parent-category/{slug}', [CategoryController::class, 'showParent'])->name('category.parent.show');

// Route for handling news search
Route::get('/search', [NewsController::class, 'search'])->name('news.search');

// Route for main news listing page
Route::get('/news', [NewsController::class, 'index'])->name('news.index');

// API route for getting all categories as JSON

// Removed redundant /tintrongloai route
// Route::get('/tintrongloai', function () {
//     return view('client.tintrongloai.index');
// })->name('tintrongloai');

Route::get('/dashboard', function () {
    $page_title = 'Dashboard';
    return view('admin.dashboard.dashboard', compact('page_title'));
})->middleware(['auth', 'verified', 'admin'])->name('admin.dashboard');

// Comment Submission Route (requires authentication)
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');

// Comment Like/Unlike Route (requires authentication)
Route::post('/comments/{comment}/like', [CommentController::class, 'toggleLike'])->name('comments.like')->middleware('auth');

// News Like/Unlike Route (requires authentication)
Route::post('/news/{news}/like', [NewsController::class, 'toggleLike'])->name('news.like')->middleware('auth');


Route::middleware(['auth', 'admin'])->group(function () {
    //Category
    Route::get('/admin/categories/create', [AdminCategoryController::class, 'create'])->name('admin.category.create');
    Route::post('/admin/categories/store', [AdminCategoryController::class, 'store'])->name('admin.category.store');
    Route::get('/admin/categories/list', [AdminCategoryController::class, 'index'])->name('admin.category.list');
    Route::get('/admin/categories/edit/{slug}', [AdminCategoryController::class, 'edit'])->name('admin.category.edit');
    Route::put('/admin/categories/update/{slug}', [AdminCategoryController::class, 'update'])->name('admin.category.update'); // Changed POST to PUT
    Route::put('/admin/categories/hide/{slug}', [AdminCategoryController::class, 'hide'])->name('admin.category.hide');
    Route::put('/admin/categories/show/{slug}', [AdminCategoryController::class, 'show'])->name('admin.category.show');
    Route::delete('/admin/categories/{slug}', [AdminCategoryController::class, 'destroy'])->name('admin.category.destroy'); // Add DELETE route

    Route::get('/api/categories', [AdminCategoryController::class, 'apiIndex'])->name('api.categories.index');

    //News
    Route::get('/admin/news/create', [AdminNewsController::class, 'create'])->name('admin.news.create');
    Route::post('/admin/news/store', [AdminNewsController::class, 'store'])->name('admin.news.store');
    Route::get('/admin/news/list', [AdminNewsController::class, 'index'])->name('admin.news.list');
    Route::get('/admin/news/edit/{slug}', [AdminNewsController::class, 'edit'])->name('admin.news.edit');
    Route::put('/admin/news/update/{slug}', [AdminNewsController::class, 'update'])->name('admin.news.update');
    Route::delete('/admin/news/{slug}', [AdminNewsController::class, 'destroy'])->name('admin.news.destroy'); // Add DELETE route

    // Route for CKEditor image uploads
    Route::post('/admin/ckeditor/upload', [AdminNewsController::class, 'ckeditorUpload'])->name('admin.ckeditor.upload');

    //profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Management Routes
    Route::resource('/admin/users', AdminUserController::class)->names('admin.users');

});


require __DIR__ . '/auth.php';
