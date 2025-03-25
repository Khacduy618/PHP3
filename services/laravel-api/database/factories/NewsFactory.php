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
        $title = fake()->sentence();
        return [
            'user_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'summary' => fake()->paragraph(),
            'content' => fake()->text(1000),
            'thumbnail' => fake()->imageUrl(640, 480, 'news'),
            'category_id' => Category::factory(),
            'views' => fake()->numberBetween(0, 1000),
            'status' => fake()->randomElement(['draft', 'published', 'archived']),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
