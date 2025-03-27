<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['Kinh doanh', 'Thể thao', 'Công nghệ', 'Sức khỏe', 'Đời sống', 'Giải trí'];
        static $index = 0;
        $name = $categories[$index % count($categories)] . ' ' . $this->faker->unique()->numberBetween(1, 1000); // Thêm số ngẫu nhiên vào tên
        $index++;
        return [
            'name' => $name,
            'slug' => Str::slug($name), // Tạo slug từ tên danh mục
            'description' => $this->faker->sentence(), // Mô tả ngắn gọn
            'parent_id' => null, // Mặc định không có danh mục cha
        ];
    }

    /**
     * State for subcategories (child categories).
     */
    public function child(Category $parentCategory): static
    {
        return $this->state(fn(array $attributes) => [
            'parent_id' => $parentCategory->id, // Liên kết với danh mục cha
        ]);
    }
}
