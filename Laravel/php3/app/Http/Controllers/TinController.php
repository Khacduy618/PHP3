<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\DB;

class TinController extends Controller
{   
    public function index(){
        return view('home');
    }
    public function contact(){
        return view('contact');
    }

    public function detail($id){
        return view('detail');
    }
}
