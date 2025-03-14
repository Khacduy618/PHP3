<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UsersController extends Controller
{
    public function index(){
        $users = DB::table("users")->get();
        return view("users.list",compact("users"));
    }

    public function show($user_code){
        $user = DB::table("users")->where("user_code", "=" ,$user_code)->first();
        return view("details_user",compact("user"));
    }
}
