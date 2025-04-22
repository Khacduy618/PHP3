<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use App\Models\Subscriber;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB; // Keep DB facade for tags if needed, or remove if using Eloquent pluck/map
use Illuminate\Database\Eloquent\Builder; // Import Builder for type hinting
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Tin nổi bật (is_featured): 5 tin (1 chính, 4 phụ - layout handled in view)
        $featuredNews = News::query()
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->where('is_featured', true)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // 2. Tin trending (is_trending): 10 tin
        $trendingNews = News::query()
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->where('is_trending', true)
            ->orderByDesc('views')
            ->limit(10)
            ->get();

        // 3. Tin mới nhất: 10 tin
        $latestNews = News::query()
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        // 4. Tin tức theo loại (tintrongloai): Parent categories + 10 news per parent group
        $parentCategories = Category::query()
            ->whereNull('parent_id')
            ->where('status', 'Hiện')
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();

        $newsByParentCategory = [];
        foreach ($parentCategories as $parentCategory) {
            $childCategoryIds = Category::query()
                ->where('parent_id', $parentCategory->id)
                ->where('status', 'Hiện')
                ->whereNull('deleted_at')
                ->pluck('id');

            $news = News::query()
                ->with('category')
                ->where('status', 'published')
                ->whereNull('deleted_at')
                ->whereIn('category_id', $childCategoryIds)
                ->orderByDesc('created_at')
                ->limit(4)
                ->get();

            if ($news->isNotEmpty()) {
                $newsByParentCategory[$parentCategory->id] = $news;
            }
        }

        $hotNews = News::query()
            ->where('status', 'published')
            ->where('is_hot', true)
            ->whereNull('deleted_at')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $allTags = News::query()
            ->where('status', 'published')
            ->whereNotNull('tags')
            ->pluck('tags')
            ->flatMap(function ($jsonString) {
                return json_decode($jsonString, true) ?? [];
            })
            ->filter()
            ->unique()
            ->values()
            ->take(15);

        $page_title = 'Trang chủ - ' . config('app.name', 'Laravel');

        return view('client.home.home', compact(
            'page_title',
            'featuredNews',
            'trendingNews',
            'latestNews',
            'parentCategories',
            'newsByParentCategory',
            'hotNews',
            'allTags'
        ));
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers',
        ]);

        Subscriber::create([
            'email' => $request->email,
            'unsubscribe_token' => Str::uuid(),
        ]);

        return redirect()->back()->with('success', 'Cảm ơn bạn đã đăng ký!');
    }

    public function unsubscribe($token)
    {
        $subscriber = Subscriber::where('unsubscribe_token', $token)->first();

        if ($subscriber) {
            $subscriber->delete();
            return redirect('/')->with('success', 'Bạn đã hủy đăng ký thành công!');
        } else {
            return redirect('/')->with('error', 'Mã hủy đăng ký không hợp lệ.');
        }
    }
}
