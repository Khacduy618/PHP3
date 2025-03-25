<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\News;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\Advertisement;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tạo người dùng
        User::factory(10)->create();

        // Tạo danh mục
        Category::factory(5)->create();

        // Tạo bài viết
        News::factory(20)->create();

        // Tạo bình luận
        Comment::factory(50)->create();

        // Tạo tags
        Tag::factory(10)->create();

        // Tạo quảng cáo
        Advertisement::factory(3)->create();

        $users = User::all();
        $newsList = News::all();

        foreach ($newsList as $news) {
            // Mỗi bài viết sẽ có từ 1-5 lượt thích
            $randomUsers = $users->random(rand(1, 5));
            foreach ($randomUsers as $user) {
                Like::create([
                    'user_id' => $user->id,
                    'news_id' => $news->id,
                ]);
            }
        }

        // Tạo liên kết giữa bài viết và tags
        $tags = Tag::all();
        News::all()->each(function ($news) use ($tags) {
            $news->tags()->attach($tags->random(rand(1, 3))->pluck('id')->toArray());
        });
    }
}
