<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Danh sách tên danh mục cố định
        $categories = ['Kinh doanh', 'Thể thao', 'Công nghệ', 'Sức khỏe', 'Đời sống', 'Giải trí'];

        // Tạo danh mục từ danh sách
        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name), // Tạo slug từ tên danh mục
                'description' => fake()->sentence(), // Mô tả ngắn gọn
                'parent_id' => null, // Mặc định không có danh mục cha
            ]);
        }
    }
}
