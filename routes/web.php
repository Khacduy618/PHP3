<?php

use App\Http\Controllers\Admin\AdminNewsController;
use App\Http\Controllers\Client\CategoryController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\NewsController;
use App\Http\Controllers\Client\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminUserController;
use Illuminate\Support\Facades\Route;

Route::post('/subscribe', [HomeController::class, 'subscribe'])->name('subscribe');
Route::get('/unsubscribe/{token}', [HomeController::class, 'unsubscribe'])->name('unsubscribe');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/tag/{tag}', [NewsController::class, 'showByTag'])->name('news.by_tag');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/parent-category/{slug}', [CategoryController::class, 'showParent'])->name('category.parent.show');
Route::get('/search', [NewsController::class, 'search'])->name('news.search');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');

Route::get('/dashboard', function () {
    $page_title = 'Dashboard';
    return view('admin.dashboard.dashboard', compact('page_title'));
})->middleware(['auth', 'verified', 'admin'])->name('admin.dashboard');

Route::post('/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');
Route::post('/comments/{comment}/like', [CommentController::class, 'toggleLike'])->name('comments.like')->middleware('auth');
Route::post('/news/{news}/like', [NewsController::class, 'toggleLike'])->name('news.like')->middleware('auth');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/categories/create', [AdminCategoryController::class, 'create'])->name('admin.category.create');
    Route::post('/admin/categories/store', [AdminCategoryController::class, 'store'])->name('admin.category.store');
    Route::get('/admin/categories/list', [AdminCategoryController::class, 'index'])->name('admin.category.list');
    Route::get('/admin/categories/edit/{slug}', [AdminCategoryController::class, 'edit'])->name('admin.category.edit');
    Route::put('/admin/categories/update/{slug}', [AdminCategoryController::class, 'update'])->name('admin.category.update');
    Route::put('/admin/categories/hide/{slug}', [AdminCategoryController::class, 'hide'])->name('admin.category.hide');
    Route::put('/admin/categories/show/{slug}', [AdminCategoryController::class, 'show'])->name('admin.category.show');
    Route::delete('/admin/categories/{slug}', [AdminCategoryController::class, 'destroy'])->name('admin.category.destroy');

    Route::get('/api/categories', [AdminCategoryController::class, 'apiIndex'])->name('api.categories.index');

    Route::get('/admin/news/create', [AdminNewsController::class, 'create'])->name('admin.news.create');
    Route::post('/admin/news/store', [AdminNewsController::class, 'store'])->name('admin.news.store');
    Route::get('/admin/news/list', [AdminNewsController::class, 'index'])->name('admin.news.list');
    Route::get('/admin/news/edit/{slug}', [AdminNewsController::class, 'edit'])->name('admin.news.edit');
    Route::put('/admin/news/update/{slug}', [AdminNewsController::class, 'update'])->name('admin.news.update');
    Route::delete('/admin/news/{slug}', [AdminNewsController::class, 'destroy'])->name('admin.news.destroy');

    Route::post('/admin/ckeditor/upload', [AdminNewsController::class, 'ckeditorUpload'])->name('admin.ckeditor.upload');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/admin/users', AdminUserController::class)->names('admin.users');
});

require __DIR__ . '/auth.php';
