<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;



class HomeController extends Controller
{
    public function index()
    {
        $page_title = 'NEWS - Trang chủ';
        $latest_news = DB::table("news")->where('status', '=', 'published')->orderByDesc('created_at')->limit(10)->get();
        $view_news = DB::table("news")->where('status', '=', 'published')->orderByDesc('view_count')->limit(10)->get();
        $popular_news = DB::table("news")->where('status', '=', 'published')->orderByDesc('comment_count')->limit(10)->get();
        $trending_news = DB::table("news")->where('status', '=', 'published')->orderByDesc('like_count')->limit(10)->get();

        return view("home.home", ['page_title' => $page_title, 'latest_news' => $latest_news, 'view_news' => $view_news, 'popular_news' => $popular_news, 'trending_news' => $trending_news]);
    }
}
