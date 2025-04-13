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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Tên danh mục
            $table->string('slug')->unique(); // Đường dẫn thân thiện với SEO
            $table->text('description')->nullable(); // Mô tả danh mục
            $table->unsignedBigInteger('parent_id')->nullable(); // ID danh mục cha (nếu có)
            $table->enum('status', ['Hiện', 'Ẩn'])->default('Hiện');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ID người dùng tạo danh mục
            $table->timestamps();

            // Khóa ngoại liên kết với chính bảng categories
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
