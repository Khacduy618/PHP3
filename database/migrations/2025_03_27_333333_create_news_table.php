<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Tiêu đề bài viết
            $table->text('content'); // Nội dung bài viết
            $table->string('summary', 500); // Tóm tắt bài viết
            $table->string('slug')->unique(); // Đường dẫn bài viết
            $table->unsignedBigInteger('views')->default(0); // Lượt xem
            $table->string('tags')->nullable(); // Thẻ bài viết
            $table->string('image')->nullable(); // Ảnh đại diện bài viết
            $table->boolean('is_hot')->default(false); // Bài viết nổi bật
            $table->boolean('is_featured')->default(false); // Bài viết được chọn
            $table->boolean('is_trending')->default(false); // Bài viết đang thịnh hành
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft'); // Trạng thái bài viết
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ID người dùng tạo bài viết
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // ID danh mục bài viết
            $table->timestamps(); // created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
