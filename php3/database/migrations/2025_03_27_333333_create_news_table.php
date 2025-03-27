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
            $table->string('image')->nullable(); // Ảnh đại diện bài viết
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft'); // Trạng thái bài viết
            $table->unsignedBigInteger('category_id'); // ID danh mục
            $table->unsignedBigInteger('user_id'); // ID người tạo bài viết
            $table->timestamps(); // created_at và updated_at

            // Khóa ngoại
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
