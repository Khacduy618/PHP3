<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\News;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->paragraph(), // Nội dung bình luận
            'user_id' => User::factory(), // Liên kết với bảng users
            'news_id' => News::factory(), // Liên kết với bảng news
            'parent_id' => null, // Mặc định không có bình luận cha
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']), // Trạng thái ngẫu nhiên
        ];
    }

    /**
     * State for replies (nested comments).
     */
    public function reply(Comment $parentComment): static
    {
        return $this->state(fn(array $attributes) => [
            'parent_id' => $parentComment->id, // Liên kết với bình luận cha
        ]);
    }
}
