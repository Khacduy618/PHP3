<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Trang chi tiết tin tức
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.detail');

// Trang tin tức theo loại
Route::get('/category/{slug}', [NewsController::class, 'showByCategory'])->name('category.news');

// Đăng ký
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Đăng nhập
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Quản trị loại tin
// Route::prefix('admin/categories')->middleware('auth')->group(function () {
//     Route::get('/', [CategoryController::class, 'index'])->name('admin.categories.index');
//     Route::get('/create', [CategoryController::class, 'create'])->name('admin.categories.create');
//     Route::post('/store', [CategoryController::class, 'store'])->name('admin.categories.store');
//     Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('admin.categories.edit');
//     Route::put('/update/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
//     Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.delete');
// });

// // Quản trị tin tức
// Route::prefix('admin/news')->middleware('auth')->group(function () {
//     Route::get('/', [NewsController::class, 'index'])->name('admin.news.index');
//     Route::get('/create', [NewsController::class, 'create'])->name('admin.news.create');
//     Route::post('/store', [NewsController::class, 'store'])->name('admin.news.store');
//     Route::get('/edit/{id}', [NewsController::class, 'edit'])->name('admin.news.edit');
//     Route::put('/update/{id}', [NewsController::class, 'update'])->name('admin.news.update');
//     Route::delete('/delete/{id}', [NewsController::class, 'destroy'])->name('admin.news.delete');
// });
