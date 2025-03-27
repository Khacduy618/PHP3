<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $page_title = 'NEWS - Trang chủ';

        // 1. Lấy 1 news mới nhất
        $latestNews = DB::table('news')
            ->join('categories', 'news.category_id', '=', 'categories.id')
            ->join('users', 'news.user_id', '=', 'users.id')
            ->select('news.*', 'categories.name as category_name', 'users.name as user_name')
            ->where('news.status', 'published')
            ->orderBy('news.created_at', 'desc')
            ->first();

        // 2. Lấy 3 news tiếp theo sau
        $nextThreeNews = DB::table('news')
            ->join('categories', 'news.category_id', '=', 'categories.id')
            ->join('users', 'news.user_id', '=', 'users.id')
            ->select('news.*', 'categories.name as category_name', 'users.name as user_name')
            ->where('news.status', 'published')
            ->orderBy('news.created_at', 'desc')
            ->skip(1)
            ->take(3)
            ->get();

        // 3. Lấy 5 news tiếp theo sau tiếp
        $nextFiveNews = DB::table('news')
            ->join('categories', 'news.category_id', '=', 'categories.id')
            ->join('users', 'news.user_id', '=', 'users.id')
            ->select('news.*', 'categories.name as category_name', 'users.name as user_name')
            ->where('news.status', 'published')
            ->orderBy('news.created_at', 'desc')
            ->skip(4)
            ->take(5)
            ->get();

        // 4. Lấy 10 news được bình luận nhiều nhất trong tuần
        $mostCommentedNews = DB::table('news')
            ->join('categories', 'news.category_id', '=', 'categories.id')
            ->join('users', 'news.user_id', '=', 'users.id')
            ->leftJoin('comments', 'news.id', '=', 'comments.news_id')
            ->select(
                'news.id',
                'news.title',
                'news.slug',
                'news.content',
                'news.summary',
                'news.image',
                'news.views',
                'news.created_at',
                'news.updated_at',
                'categories.name as category_name',
                'users.name as user_name',
                DB::raw('COUNT(comments.id) as comments_count')
            )
            ->where('news.status', 'published')
            ->whereBetween('comments.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->groupBy(
                'news.id',
                'news.title',
                'news.slug',
                'news.content',
                'news.summary',
                'news.image',
                'news.views',
                'news.created_at',
                'news.updated_at',
                'categories.name',
                'users.name'
            )
            ->orderBy('comments_count', 'desc')
            ->take(10)
            ->get();

        // 5. Lấy 10 news theo category_id
        $newsByCategory1 = DB::table('news')
            ->join('categories', 'news.category_id', '=', 'categories.id')
            ->join('users', 'news.user_id', '=', 'users.id')
            ->select('news.*', 'categories.name as category_name', 'users.name as user_name')
            ->where('news.status', 'published')
            ->whereIn('news.category_id', function ($query) {
                $query->select('id')
                    ->from('categories')
                    ->where('parent_id', 1);
            })
            ->orderBy('news.created_at', 'desc')
            ->take(4)
            ->get();

        $newsByCategory2 = DB::table('news')
            ->join('categories', 'news.category_id', '=', 'categories.id')
            ->join('users', 'news.user_id', '=', 'users.id')
            ->select('news.*', 'categories.name as category_name', 'users.name as user_name')
            ->where('news.status', 'published')
            ->whereIn('news.category_id', function ($query) {
                $query->select('id')
                    ->from('categories')
                    ->where('parent_id', 2);
            })
            ->orderBy('news.created_at', 'desc')
            ->take(4)
            ->get();

        $newsByCategory3 = DB::table('news')
            ->join('categories', 'news.category_id', '=', 'categories.id')
            ->join('users', 'news.user_id', '=', 'users.id')
            ->select('news.*', 'categories.name as category_name', 'users.name as user_name')
            ->where('news.status', 'published')
            ->whereIn('news.category_id', function ($query) {
                $query->select('id')
                    ->from('categories')
                    ->where('parent_id', 3);
            })
            ->orderBy('news.created_at', 'desc')
            ->take(4)
            ->get();

        $newsByCategory4 = DB::table('news')
            ->join('categories', 'news.category_id', '=', 'categories.id')
            ->join('users', 'news.user_id', '=', 'users.id')
            ->select('news.*', 'categories.name as category_name', 'users.name as user_name')
            ->where('news.status', 'published')
            ->whereIn('news.category_id', function ($query) {
                $query->select('id')
                    ->from('categories')
                    ->where('parent_id', 4);
            })
            ->orderBy('news.created_at', 'desc')
            ->take(4)
            ->get();

        $newsByCategory5 = DB::table('news')
            ->join('categories', 'news.category_id', '=', 'categories.id')
            ->join('users', 'news.user_id', '=', 'users.id')
            ->select('news.*', 'categories.name as category_name', 'users.name as user_name')
            ->where('news.status', 'published')
            ->whereIn('news.category_id', function ($query) {
                $query->select('id')
                    ->from('categories')
                    ->where('parent_id', 5);
            })
            ->orderBy('news.created_at', 'desc')
            ->take(4)
            ->get();

        $newsByCategory6 = DB::table('news')
            ->join('categories', 'news.category_id', '=', 'categories.id')
            ->join('users', 'news.user_id', '=', 'users.id')
            ->select('news.*', 'categories.name as category_name', 'users.name as user_name')
            ->where('news.status', 'published')
            ->whereIn('news.category_id', function ($query) {
                $query->select('id')
                    ->from('categories')
                    ->where('parent_id', 6);
            })
            ->orderBy('news.created_at', 'desc')
            ->take(4)
            ->get();


        // 6. Lấy 10 news nhiều lượt xem nhất
        $mostViewedNews = DB::table('news')
            ->join('categories', 'news.category_id', '=', 'categories.id')
            ->join('users', 'news.user_id', '=', 'users.id')
            ->select('news.*', 'categories.name as category_name', 'users.name as user_name')
            ->where('news.status', 'published')
            ->orderBy('news.views', 'desc')
            ->take(10)
            ->get();

        return view('client.home', compact(
            'page_title',
            'latestNews',
            'nextThreeNews',
            'nextFiveNews',
            'mostCommentedNews',
            'newsByCategory1',
            'newsByCategory2',
            'newsByCategory3',
            'newsByCategory4',
            'newsByCategory5',
            'newsByCategory6',
            'mostViewedNews'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
