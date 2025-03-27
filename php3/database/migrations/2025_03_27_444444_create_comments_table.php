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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('content'); // Nội dung bình luận
            $table->unsignedBigInteger('user_id'); // ID người dùng bình luận
            $table->unsignedBigInteger('news_id'); // ID bài viết được bình luận
            $table->unsignedBigInteger('parent_id')->nullable(); // ID bình luận cha (nếu là trả lời)
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); // Trạng thái bình luận
            $table->timestamps(); // created_at và updated_at

            // Khóa ngoại
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
