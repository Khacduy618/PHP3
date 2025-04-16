<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CategoryController extends Controller
{
    /**
     * Display the specified category and its news.
     *
     * @param  string  $slug
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function show(string $slug, Request $request) // Added Request $request
    {

        $category = Category::query()->where('slug', $slug)
            ->where('status', 'Hiện')
            ->whereNull('deleted_at')
            ->firstOrFail();

        // Base query for news in this category
        $newsQuery = News::query()
            ->where('category_id', $category->id)
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->with(['category', 'user'])
            ->withCount(['likers', 'comments']); // Ensure using 'likers'

        // Sorting logic
        $sortBy = $request->input('sort_by', 'date'); // Default to date
        switch ($sortBy) {
            case 'views':
                $newsQuery->orderByDesc('views');
                break;
            case 'likes':
                $newsQuery->orderByDesc('likers_count'); // Ensure using 'likers_count'
                break;
            case 'comments':
                $newsQuery->orderByDesc('comments_count');
                break;
            case 'date':
            default:
                $newsQuery->latest(); // Order by created_at descending
                break;
        }

        // Paginate the results and append sorting parameter
        $newsItems = $newsQuery->paginate(5)->appends($request->query());

        // Fetch data for the sidebar (Hot News and Tags) as Composer was denied
        $hotNews = News::query()
            ->where('status', 'published')
            ->where('is_hot', true)
            ->whereNull('deleted_at')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $allTags = News::query()
            ->where('status', 'published')
            ->whereNotNull('tags') // Still check if the JSON column is not null
            // ->where('tags', '!=', '') // No longer needed for JSON
            ->pluck('tags') // Pluck the 'tags' column (which contains JSON strings)
            ->flatMap(function ($jsonString) {
                // Decode each JSON string into an array, handle potential nulls/errors
                return json_decode($jsonString, true) ?? [];
            })
            ->filter() // Remove any empty tags resulting from decoding issues or empty arrays
            ->unique() // Ensure uniqueness
            ->values() // Reset array keys
            ->take(15);
        $trendingNews = News::query()
            ->where('status', 'published')
            ->where('is_trending', true)
            ->whereNull('deleted_at')
            ->orderByDesc('views')
            ->limit(10)
            ->get();

        $page_title = 'Danh mục: ' . $category->name . ' - ' . config('APP_NAME', 'Laravel');
        // Pass all data (category, news, sidebar data) to the view
        return view('client.tintrongloai.index', compact(
            'page_title',
            'category',
            'newsItems',
            'hotNews',
            'allTags',
            'trendingNews',
            'sortBy' // Pass sortBy to the view
        ));
    }

    /**
     * Display news for a parent category (all its children).
     *
     * @param  string  $slug
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function showParent(string $slug, Request $request)
    {
        // Find the parent category
        $parentCategory = Category::query()
            ->where('slug', $slug)
            ->whereNull('parent_id') // Ensure it's a parent
            ->where('status', 'Hiện')
            ->whereNull('deleted_at')
            ->firstOrFail();

        // Get IDs of its direct children
        $childCategoryIds = Category::query()
            ->where('parent_id', $parentCategory->id)
            ->where('status', 'Hiện')
            ->whereNull('deleted_at')
            ->pluck('id');

        // Base query for news in child categories
        $newsQuery = News::query()
            ->whereIn('category_id', $childCategoryIds)
            ->where('status', 'published')
            ->whereNull('deleted_at')
            ->with(['category', 'user'])
            ->withCount(['likers', 'comments']);

        // Sorting logic (same as show method)
        $sortBy = $request->input('sort_by', 'date'); // Default to date
        switch ($sortBy) {
            case 'views':
                $newsQuery->orderByDesc('views');
                break;
            case 'likes':
                $newsQuery->orderByDesc('likers_count');
                break;
            case 'comments':
                $newsQuery->orderByDesc('comments_count');
                break;
            case 'date':
            default:
                $newsQuery->latest();
                break;
        }

        // Paginate the results and append sorting parameter
        $newsItems = $newsQuery->paginate(5)->appends($request->query());

        // Fetch data for the sidebar (Hot News and Tags)
        $hotNews = News::query()
            ->where('status', 'published')
            ->where('is_hot', true)
            ->orderByDesc('created_at')
            ->whereNull('deleted_at')
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

        $trendingNews = News::query()
            ->where('status', 'published')
            ->where('is_trending', true)
            ->orderByDesc('views')
            ->whereNull('deleted_at')
            ->limit(10)
            ->get();

        $page_title = 'Danh mục: ' . $parentCategory->name . ' - ' . config('app.name', 'Laravel');

        // Reuse the same view as the child category display, passing the parent category
        return view('client.tintrongloai.index', [
            'category' => $parentCategory, // Pass parent category as 'category'
            'newsItems' => $newsItems,
            'hotNews' => $hotNews,
            'allTags' => $allTags,
            'trendingNews' => $trendingNews,
            'sortBy' => $sortBy,
            'page_title' => $page_title
        ]);
    }
}
