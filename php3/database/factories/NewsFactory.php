<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(6, true); // Tạo tiêu đề ngẫu nhiên
        return [
            'title' => $title,
            'content' => $this->faker->paragraphs(5, true), // Nội dung bài viết
            'summary' => $this->faker->text(200), // Tóm tắt bài viết
            'slug' => Str::slug($title), // Tạo slug từ tiêu đề
            'views' => $this->faker->numberBetween(0, 1000), // Lượt xem ngẫu nhiên
            'image' => $this->faker->imageUrl(640, 480, 'news', true), // Ảnh đại diện ngẫu nhiên
            'status' => $this->faker->randomElement(['draft', 'published', 'archived']), // Trạng thái ngẫu nhiên
            'category_id' => Category::factory(), // Liên kết với danh mục
            'user_id' => User::factory(), // Liên kết với người dùng
        ];
    }
}
