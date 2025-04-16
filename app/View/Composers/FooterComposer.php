<?php

namespace App\View\Composers;

use App\Models\Category;
use App\Models\News;
use Illuminate\View\View;

class FooterComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // 1. Fetch Categories for the footer menu (e.g., top-level active categories)
        $footerCategories = Category::query()
            ->whereNull('parent_id') // Get only parent categories
            ->where('status', 'Hiện') // Only active ones
            ->orderBy('name')        // Order alphabetically
            ->limit(8)               // Limit the number shown
            ->get();

        // 2. Fetch Most Viewed Posts (e.g., top 3 published news by views)
        $mostViewedPosts = News::query()
            ->where('status', 'published')
            ->whereNull('deleted_at') // Ensure not soft-deleted
            ->orderByDesc('views')
            ->limit(3)
            ->get();

        // 3. Fetch Last Modified/Latest Posts (e.g., latest 9 published news for the image grid)
        $latestPostsImages = News::query()
            ->where('status', 'published')
            ->whereNotNull('image') // Ensure they have an image
            ->whereNull('deleted_at') // Ensure not soft-deleted
            ->latest() // Order by newest first
            ->limit(9)
            ->get(['slug', 'image', 'title']); // Select only needed fields

        // Bind data to the view
        $view->with('footerCategories', $footerCategories)
            ->with('mostViewedPosts', $mostViewedPosts)
            ->with('latestPostsImages', $latestPostsImages);
    }
}
