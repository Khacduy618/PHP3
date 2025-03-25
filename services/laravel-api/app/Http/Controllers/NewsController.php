<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
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

    public function top_10_news(Request $request)
    {
        $limit = $request->input('limit', 10); // mặc định 10 nếu không truyền limit
        $top_news = News::orderByDesc('views')->limit($limit)->get();
        return view('news.top_10_news', compact('top_news'));
    }
}
