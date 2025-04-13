<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;

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
        $title = fake()->unique()->sentence(rand(5, 12));
        $contentParagraphs = rand(15, 40);

        // Cơ hội để các cờ boolean là true (ví dụ: 15% cho featured, 10% cho hot, 20% cho trending)
        $is_featured = fake()->boolean(15);
        $is_hot = fake()->boolean(10);
        $is_trending = fake()->boolean(20);

        // Đảm bảo ít nhất 1 cờ là true nếu không cờ nào true (tùy chọn)
        // if (!$is_featured && !$is_hot && !$is_trending && fake()->boolean(30)) {
        //     $flags = ['is_featured', 'is_hot', 'is_trending'];
        //     $randomFlag = $flags[array_rand($flags)];
        //     $$randomFlag = true; // Sử dụng biến biến để gán lại cờ ngẫu nhiên thành true
        // }


        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . uniqid(), // Đảm bảo slug unique
            'content' => '<p>' . implode('</p><p>', fake()->paragraphs($contentParagraphs)) . '</p>',
            'summary' => fake()->paragraph(rand(3, 6)),
            'views' => fake()->numberBetween(50, 15000),
            'image' => fake()->imageUrl(800, 600, 'business', true), // Có thể thay đổi chủ đề ảnh
            'status' => fake()->randomElement(['published', 'published', 'published', 'published', 'draft']), // Ưu tiên published
            'is_featured' => $is_featured,
            'is_hot' => $is_hot,
            'is_trending' => $is_trending,
            // user_id và category_id sẽ được gán trong Seeder
            'user_id' => User::where('role', 'admin')->first()?->id ?? User::factory()->admin()->create()->id, // Mặc định là admin
            'category_id' => Category::whereNotNull('parent_id')->inRandomOrder()->first()?->id ?? Category::factory()->subCategory(Category::factory()->create()->id)->create()->id, // Mặc định là category con ngẫu nhiên
            'created_at' => fake()->dateTimeBetween('-2 years', 'now'),
            'updated_at' => function (array $attributes) {
                return fake()->dateTimeBetween($attributes['created_at'], 'now');
            },
        ];
    }
    // Có thể thêm state để set category/user cụ thể nếu cần
    public function forCategory(Category $category): static
    {
        return $this->state(fn(array $attributes) => [
            'category_id' => $category->id,
            // Có thể cập nhật image placeholder dựa trên category cha
            // 'image' => fake()->imageUrl(800, 600, $this->getThemeForCategory($category), true),
        ]);
    }

    public function byUser(User $user): static
    {
        return $this->state(fn(array $attributes) => [
            'user_id' => $user->id,
        ]);
    }

    // Hàm helper ví dụ để lấy theme ảnh (tùy chọn)
    private function getThemeForCategory(Category $category): string
    {
        $parent = $category->parent ?? $category; // Lấy category cha nếu có
        switch (strtolower($parent->slug)) {
            case 'the-thao':
                return 'sports';
            case 'cong-nghe':
                return 'technics';
            case 'suc-khoe':
                return 'health';
            case 'doi-song':
                return 'people';
            case 'giai-tri':
                return 'nightlife';
            case 'kinh-doanh':
            default:
                return 'business';
        }
    }

    /**
     * Indicate that the news status is draft.
     */
    public function draft(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'draft',
        ]);
    }

    /**
     * Indicate that the news status is archived.
     */
    public function archived(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => 'archived',
        ]);
    }
}
