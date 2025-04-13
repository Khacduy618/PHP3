<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để bình luận.');
        }

        $request->validate([
            'news_id' => 'required|exists:news,id',
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id', // Validate if it's a reply
        ]);

        // Find the news item to associate the comment with
        $news = News::findOrFail($request->input('news_id'));

        // Create the comment
        Comment::create([
            'content' => $request->input('content'),
            'user_id' => Auth::id(),
            'news_id' => $news->id,
            'parent_id' => $request->input('parent_id', null), // Set parent_id if provided
        ]);

        // Redirect back to the news article page with a success message
        // We need the news slug to redirect correctly
        return redirect()->route('news.show', $news->slug)->with('success', 'Bình luận của bạn đã được gửi.');
    }

    /**
     * Toggle the like status for a comment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleLike(Request $request, Comment $comment)
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để thích bình luận.');
        }

        // Toggle the like status for the authenticated user
        // The toggle method attaches if not attached, detaches if attached.
        Auth::user()->likedComments()->toggle($comment->id);

        // Redirect back to the news article page
        // We need the news slug associated with the comment
        return redirect()->route('news.show', $comment->news->slug)->with('status', 'Like status updated.'); // Use 'status' for neutral message
    }
}
