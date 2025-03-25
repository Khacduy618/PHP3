<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\HomeController;


Route::get('/', [HomeController::class, 'index']);

Route::get('/home', [NewsController::class, 'index']);

Route::get('/contact', [NewsController::class, 'contact']);

Route::get('/detail/{id}', [NewsController::class, 'detail']);

Route::get('/details_user/{user_code}', [UserController::class, 'show']);

// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/news/{news_id}/like', [LikeController::class, 'like']);
//     Route::post('/news/{news_id}/unlike', [LikeController::class, 'unlike']);
// });

Route::get('/top_news/{limit}', [NewsController::class, 'top_10_news']);
