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
        Schema::create('likes', function (Blueprint $table) {
            // Composite primary key
            $table->primary(['user_id', 'news_id']);

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('news_id')->constrained()->onDelete('cascade');
            $table->timestamps(); // Optional: track when like was created/updated
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
