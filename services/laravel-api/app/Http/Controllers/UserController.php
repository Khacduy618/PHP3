<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use MongoDB\Laravel\Eloquent\Casts\ObjectId;

class UserController extends Controller
{
    public function index()
    {
        $users = DB::table("users")->orderBy('_id')->get();
        return view('user', compact("users"));
    }

    public function show($user_id)
    {
        $user = DB::connection('mongodb')->table("users")->where('id', '=', $user_id)->first();
        return view("details_user", compact("user"));
    }
}
// try {
//     $databases = DB::connection('mongodb')->getMongoClient()->listDatabaseNames();

//     return response()->json([
//         'status' => 'success',
//         'databases' => $databases
//     ]);
// } catch (\Exception $e) {
//     return response()->json([
//         'status' => 'error',
//         'message' => $e->getMessage()
//     ], 500);
// }
