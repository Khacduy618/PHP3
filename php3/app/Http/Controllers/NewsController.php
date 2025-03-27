<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(string $slug)
    {

        $news = DB::table('news')->where('slug', $slug)->first();
        $title = $news->title;
        $page_title = 'NEWS - ' . $title;
        return view('client.details', compact('news', 'page_title'));
    }

    /**
     * Display news by category.
     */
    public function showByCategory(string $slug)
    {
        $category = DB::table('categories')->where('slug', $slug)->first();
        $id = $category->id;

        $news = DB::table('news')
            ->join('users', 'news.user_id', '=', 'users.id')
            ->join('categories', 'news.category_id', '=', 'categories.id')
            ->select('news.*', 'users.name as author', 'categories.name as category_name')
            ->where('news.status', 'published')
            ->whereIn('news.category_id', function ($query) use ($id) {
                $query->select('id')
                    ->from('categories')
                    ->where('parent_id', $id);
            })
            ->get();

        $page_title = 'NEWS - ' . $category->name;

        return view('client.news_byCategory', compact('news', 'page_title', 'category'));
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
