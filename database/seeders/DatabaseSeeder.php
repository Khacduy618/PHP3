<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\News;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Starting database seeding...');

        // Tắt kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->command->info('Foreign key checks disabled.');

        // Xóa dữ liệu cũ
        $this->command->warn('Truncating tables: like, news, categories, users...');
        DB::table('like')->truncate();
        DB::table('news')->truncate();
        DB::table('categories')->truncate();
        DB::table('users')->truncate();
        DB::table('password_reset_tokens')->truncate();
        DB::table('sessions')->truncate();
        $this->command->info('Tables truncated.');

        // Bật lại kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->command->info('Foreign key checks enabled.');

        // === 1. Tạo Users ===
        $this->command->info('Creating Admin User...');
        $admin = User::factory()->admin()->create([
            'name' => 'Admin News',
            'email' => 'admin@newsportal.com',
            'password' => Hash::make('password'), // Đặt mật khẩu đơn giản cho seeding
        ]);
        $this->command->info('> Admin user created: admin@newsportal.com / password');

        $this->command->info('Creating Viewer Users...');
        $viewers = User::factory(20)->create(['role' => 'viewer']); // Tạo 20 người xem
        $this->command->info('> Created ' . $viewers->count() . ' viewer users.');
        $allViewerIds = $viewers->pluck('id');

        // === 2. Tạo Categories (Parent & Child) ===
        $this->command->info('Creating categories structure...');
        $categoryStructure = [
            'Kinh doanh' => ['Khởi nghiệp', 'Bất động sản', 'Tài chính', 'Marketing', 'Doanh nhân'],
            'Thể thao' => ['Bóng đá', 'Bóng rổ', 'Quần vợt', 'Đua xe', 'Võ thuật', 'Esports'],
            'Công nghệ' => ['Điện thoại', 'Máy tính', 'Phần mềm', 'Internet', 'AI', 'Khoa học'],
            'Sức khỏe' => ['Dinh dưỡng', 'Làm đẹp', 'Bài thuốc', 'Giới tính', 'Tập luyện'],
            'Đời sống' => ['Du lịch', 'Ẩm thực', 'Thời trang', 'Gia đình', 'Showbiz'],
            'Giải trí' => ['Phim ảnh', 'Âm nhạc', 'Truyền hình', 'Game', 'Sách', 'Sự kiện'],
        ];

        $allChildCategoryIds = collect(); // Collection để lưu ID của TẤT CẢ category con

        foreach ($categoryStructure as $parentName => $children) {
            // Tạo Parent Category
            $parentCategory = Category::create([
                'name' => $parentName,
                'slug' => Str::slug($parentName),
                'description' => 'Tin tức về ' . $parentName,
                'parent_id' => null,
                'user_id' => $admin->id, // Admin tạo
                'status' => 'Hiện',
            ]);
            $this->command->line('  Created parent: ' . $parentName);

            // Tạo Child Categories
            foreach ($children as $childName) {
                $childCategory = Category::create([
                    'name' => $childName,
                    'slug' => Str::slug($childName) . '-' . $parentCategory->slug, // Thêm slug cha để tăng unique
                    'description' => 'Chuyên mục ' . $childName . ' thuộc ' . $parentName,
                    'parent_id' => $parentCategory->id, // Liên kết với cha
                    'user_id' => $admin->id, // Admin tạo
                    'status' => 'Hiện',
                ]);
                $allChildCategoryIds->push($childCategory->id); // Thêm ID con vào collection
                $this->command->line('    Created child: ' . $childName);
            }
        }
        $this->command->info('> Category structure created. Total child categories: ' . $allChildCategoryIds->count());

        // === 3. Tạo News (Cho Category Con) ===
        if ($allChildCategoryIds->isEmpty()) {
            $this->command->error('No child categories found to create news for. Seeding aborted for news.');
            return;
        }

        $numberOfNews = 150; // Số lượng bài viết muốn tạo
        $this->command->info('Creating ' . $numberOfNews . ' news items for child categories...');
        $createdNewsIds = collect();

        for ($i = 0; $i < $numberOfNews; $i++) {
            $randomChildCategoryId = $allChildCategoryIds->random();
            $news = News::factory()
                ->state([ // Ghi đè state trực tiếp trong seeder
                    'category_id' => $randomChildCategoryId,
                    'user_id' => $admin->id, // Chỉ admin đăng bài
                ])
                ->create(); // Tạo và lưu vào DB
            $createdNewsIds->push($news->id);
            if (($i + 1) % 25 == 0) { // Log tiến trình
                $this->command->line('  Created ' . ($i + 1) . '/' . $numberOfNews . ' news items...');
            }
        }
        $this->command->info('> Created ' . $createdNewsIds->count() . ' news items.');


        // === 4. Tạo Likes (Viewer thích News) ===
        if ($createdNewsIds->isEmpty() || $allViewerIds->isEmpty()) {
            $this->command->warn('No news items or viewers found to create likes. Skipping like creation.');
        } else {
            $this->command->info('Creating likes (viewers liking news)...');
            $likesCreatedCount = 0;
            foreach ($viewers as $viewer) {
                // Mỗi viewer thích từ 10 đến 30 bài viết ngẫu nhiên
                $numberOfLikes = rand(10, min(30, $createdNewsIds->count()));
                $newsToLike = $createdNewsIds->random($numberOfLikes)->unique(); // Lấy ID news ngẫu nhiên, không trùng lặp cho user này

                foreach ($newsToLike as $newsId) {
                    DB::table('like')->insertOrIgnore([
                        'user_id' => $viewer->id,
                        'news_id' => $newsId,
                        'created_at' => now()->subDays(rand(0, 365)), // Like vào thời điểm ngẫu nhiên trong năm qua
                        'updated_at' => now(),
                    ]);
                    $likesCreatedCount++;
                }
            }
            $this->command->info('> Created approx ' . $likesCreatedCount . ' like records.');
        }

        $this->command->info('Database seeding completed successfully!');
    }
}