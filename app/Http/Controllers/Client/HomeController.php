<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Keep DB facade for tags if needed, or remove if using Eloquent pluck/map
use Illuminate\Database\Eloquent\Builder; // Import Builder for type hinting

class HomeController extends Controller
{
    public function index()
    {
        // 1. Tin nổi bật (is_featured): 5 tin (1 chính, 4 phụ - layout handled in view)
        $featuredNews = News::query()
            ->where('status', 'published')
            ->where('is_featured', true)
            ->orderByDesc('created_at') // Or specific order if needed
            ->limit(5)
            ->get();

        // 2. Tin trending (is_trending): 10 tin
        $trendingNews = News::query()
            ->where('status', 'published')
            ->where('is_trending', true)
            ->orderByDesc('views') // Assuming order by views makes sense for trending
            ->limit(10)
            ->get();

        // 3. Tin mới nhất: 10 tin
        $latestNews = News::query()
            ->where('status', 'published')
            ->orderByDesc('created_at')
            ->limit(10) // Changed limit to 10
            ->get();

        // 4. Tin tức theo loại (tintrongloai): Parent categories + 10 news per parent group
        $parentCategories = Category::query()
            ->whereNull('parent_id') // Get only parent categories
            ->where('status', 'Hiện')
            ->orderBy('name') // Order parent categories alphabetically or by preference
            ->get();

        $newsByParentCategory = [];
        foreach ($parentCategories as $parentCategory) {
            // Get IDs of direct children categories
            $childCategoryIds = Category::query()
                ->where('parent_id', $parentCategory->id)
                ->where('status', 'Hiện')
                ->pluck('id'); // Get only the IDs

            // Get 10 news items belonging to these child categories, eager load category
            $news = News::query()
                ->with('category') // Eager load the category relationship
                ->where('status', 'published')
                ->whereIn('category_id', $childCategoryIds) // News must belong to a child category
                ->orderByDesc('created_at')
                ->limit(4) // Corrected limit back to 10 as per original request
                ->get();

            if ($news->isNotEmpty()) { // Only add if there's news
                $newsByParentCategory[$parentCategory->id] = $news;
            }
        }

        // 5. Tags & Tin hot (is_hot): 10 tin hot + unique tags
        $hotNews = News::query()
            ->where('status', 'published')
            ->where('is_hot', true)
            ->orderByDesc('created_at') // Or specific order for hot news
            ->limit(5)
            ->get();

        // Assuming 'tags' is a comma-separated string column in the 'news' table
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
            ->all();


        return view('client.home.home', compact(
            'featuredNews',
            'trendingNews',
            'latestNews',
            'parentCategories',
            'newsByParentCategory',
            'hotNews',
            'allTags'
        ));
    }
}
