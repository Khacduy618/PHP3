<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

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

        $name = fake()->unique()->words(rand(2, 4), true);
        $slug = Str::slug($name);
        return [
            'name' => ucfirst($name),
            'slug' => $slug,
            'description' => fake()->sentence(rand(10, 20)),
            'parent_id' => null, // Mặc định là gốc
            // Mặc định gán cho user đầu tiên hoặc user admin nếu có
            'user_id' => User::where('role', 'admin')->first()?->id ?? User::first()?->id ?? User::factory()->create()->id,
        ];
    }
    // State để tạo category con
    public function subCategory(int $parentId): static
    {
        // Tạo tên và slug duy nhất cho subcategory
        $name = fake()->unique()->words(rand(1, 3), true);
        $slug = Str::slug($name) . '-' . $parentId; // Thêm parentId để tăng khả năng unique

        return $this->state(function (array $attributes) use ($parentId, $name, $slug) {
            return [
                'name' => ucfirst($name),
                'slug' => $slug,
                'parent_id' => $parentId,
            ];
        });
    }
}
