<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class NewsController extends Controller
{
    /**
     * Display the specified news article.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function show(string $slug)
    {
        // Eager load relationships including comments and their nested data
        $newsItem = News::query()
            ->with([
                'user',
                'category',
                'likers', // Eager load users who liked this news item
                // Load comments, their users, replies, reply users, and likers for each comment/reply
                'comments' => function ($query) {
                    $query->with(['user', 'replies.user', 'likers']);
                }
            ])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // TEMPORARY DEBUG: Check fetched news item
        // dd($newsItem);

        // Increment views (optional, consider rate limiting or queues for high traffic)
        $newsItem->increment('views');

        // Fetch related news (e.g., same category, excluding current)
        $relatedNews = News::query()
            ->where('category_id', $newsItem->category_id)
            ->where('id', '!=', $newsItem->id)
            ->where('status', 'published')
            ->orderByDesc('created_at')
            ->limit(4)
            ->get();
        $hotNews = News::query()
            ->where('status', 'published')
            ->where('is_hot', true)
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
            ->all();
        $trendingNews = News::query()
            ->where('status', 'published')
            ->where('is_trending', true)
            ->orderByDesc('views')
            ->limit(10)
            ->get();

        // Get IDs of comments liked by the current user (if logged in) for this news item
        $likedCommentIds = [];
        if (Auth::check()) {
            // Get all comment IDs for this news item first
            $commentIds = $newsItem->comments()->with('replies')->get()->pluck('replies.*.id')->flatten()->push($newsItem->comments->pluck('id'))->flatten()->unique();
            // Find which of those the user has liked
            $likedCommentIds = Auth::user()->likedComments()->whereIn('comment_id', $commentIds)->pluck('comment_id')->toArray();
        }


        // Assuming you have a view file at resources/views/client/chitiettin/index.blade.php
        return view('client.chitiettin.index', compact('newsItem', 'hotNews', 'allTags', 'relatedNews', 'trendingNews', 'likedCommentIds'));
    }

    /**
     * Display news articles for a specific category.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function showByCategory(string $slug)
    {
        $category = Category::query()
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $newsInCategory = News::query()
            ->where('category_id', $category->id)
            ->where('status', 'published')
            ->orderByDesc('created_at')
            ->paginate(10); // Add pagination

        // Assuming you have a view file at resources/views/client/tintrongloai/index.blade.php
        return view('client.tintrongloai.index', compact('category', 'newsInCategory'));
    }

    /**
     * Display news articles for a specific tag.
     *
     * @param  string  $tag
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function showByTag(string $tag, Request $request) // Added Request $request
    {
        $decodedTag = urldecode($tag);

        // Use whereJsonContains to search within the JSON 'tags' array
        $newsQuery = News::query()
            ->whereJsonContains('tags', $decodedTag) // Search JSON array
            ->where('status', 'published')
            ->with(['category', 'user']) // Eager load relationships
            ->withCount(['likes', 'comments']); // Add counts for sorting

        // Sorting logic
        $sortBy = $request->input('sort_by', 'date'); // Default to date
        switch ($sortBy) {
            case 'views':
                $newsQuery->orderByDesc('views');
                break;
            case 'likes':
                $newsQuery->orderByDesc('likes_count');
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
        $newsWithTag = $newsQuery->paginate(10)->appends($request->query());

        // Fetch data for included blocks (Sidebar and Trending) as Composers were denied
        $hotNews = News::query()
            ->where('status', 'published')
            ->where('is_hot', true)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $allTags = News::query()
            ->where('status', 'published')
            ->whereNotNull('tags')
            // ->where('tags', '!=', '') // No longer needed
            ->pluck('tags') // Pluck JSON strings
            ->flatMap(function ($jsonString) { // Corrected variable name here
                // Decode each JSON string into an array
                return json_decode($jsonString, true) ?? [];
            })
            ->filter() // Remove empty tags
            ->unique()
            ->values()
            ->all();

        $trendingNews = News::query()
            ->where('status', 'published')
            ->where('is_trending', true)
            ->orderByDesc('views')
            ->limit(10)
            ->get();

        // Return the dedicated view for tag results with all necessary data
        return view('client.tag.show', [
            'tagName' => $decodedTag,
            'newsItems' => $newsWithTag,
            'hotNews' => $hotNews,
            'allTags' => $allTags,
            'trendingNews' => $trendingNews,
            'sortBy' => $sortBy // Pass sortBy to the view
        ]);
    }

    /**
     * Display search results based on a query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Validate the query if needed (e.g., minimum length)
        if (empty($query)) {
            return redirect()->back()->with('error', 'Please enter a search term.');
        }

        // Find IDs of child categories if the query matches a parent category name
        $childCategoryIds = Category::query()
            ->whereNull('parent_id') // Find parent categories
            ->where('name', 'LIKE', '%' . $query . '%') // Matching the query
            ->with('children:id,parent_id') // Eager load only children IDs
            ->get()
            ->pluck('children.*.id') // Get IDs of all children from all matching parents
            ->flatten() // Flatten the collection of arrays into a single collection
            ->unique() // Ensure unique IDs
            ->all(); // Get as an array

        // Search for news items
        $newsItems = News::query()
            ->where('status', 'published')
            ->where(function ($q) use ($query, $childCategoryIds) {
                // Match title, content, summary
                $q->where('title', 'LIKE', '%' . $query . '%')
                    ->orWhere('content', 'LIKE', '%' . $query . '%')
                    ->orWhere('summary', 'LIKE', '%' . $query . '%')
                    // Match specific category name
                    ->orWhereHas('category', function ($catQuery) use ($query) {
                    $catQuery->where('name', 'LIKE', '%' . $query . '%');
                })
                    // Match tags using JSON contains
                    ->orWhereJsonContains('tags', $query);

                // Include news from child categories if parent name matched
                if (!empty($childCategoryIds)) {
                    $q->orWhereIn('category_id', $childCategoryIds);
                }
            })
            ->with(['category', 'user']) // Eager load relationships
            ->latest()
            ->paginate(10); // Paginate results

        // Append the query string to pagination links
        $newsItems->appends(['query' => $query]);

        // Fetch data for included blocks (Sidebar and Trending)
        $hotNews = News::query()
            ->where('status', 'published')
            ->where('is_hot', true)
            ->orderByDesc('created_at')
            ->limit(5) // Consistent limit with other places
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
            ->all();

        $trendingNews = News::query()
            ->where('status', 'published')
            ->where('is_trending', true)
            ->orderByDesc('views')
            ->limit(10)
            ->get();

        // Return a new view for search results
        return view('client.search.results', compact(
            'query',
            'newsItems',
            'hotNews',
            'allTags',
            'trendingNews'
        ));
    }

    /**
     * Toggle the like status for a news article.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news // Use route model binding
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleLike(Request $request, News $news)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thích bài viết.');
        }

        Auth::user()->likedNews()->toggle($news->id);

        // Redirect back to the news article page
        return redirect()->route('news.show', $news->slug)->with('status', 'Like status updated.');
    }
}
