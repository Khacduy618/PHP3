<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TinController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    $users = DB::table('users')->select('*')->get();
    return view('welcome', ['users'=> $users]);
});

Route::get('/home', [TinController::class, 'index']);

Route::get('/contact', [TinController::class,'contact']);

Route::get('/detail/{id}', [TinController::class,'detail']);

Route::get('/details_user/{user_code}', [UsersController::class,'show']);


