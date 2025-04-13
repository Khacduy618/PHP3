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
        Schema::create('like', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ID người dùng thích
            $table->foreignId('news_id')->constrained('news')->onDelete('cascade'); // ID bài viết được thích
            $table->timestamps(); // created_at và updated_at

            // Đảm bảo mỗi người dùng chỉ có thể thích một bài viết một lần
            $table->unique(['user_id', 'news_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('like');
    }
};
