<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\News;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class LikeController extends Controller
{
    public function like(Request $request, $news_id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $like = Like::where('user_id', $user->id)->where('news_id', $news_id)->first();

        if ($like) {
            return response()->json(['message' => 'Already liked'], 409);
        }

        Like::create([
            'user_id' => $user->id,
            'news_id' => $news_id,
        ]);

        return response()->json(['message' => 'Liked successfully']);
    }

    public function unlike(Request $request, $news_id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        Like::where('user_id', $user->id)->where('news_id', $news_id)->delete();

        return response()->json(['message' => 'Unliked successfully']);
    }
}
