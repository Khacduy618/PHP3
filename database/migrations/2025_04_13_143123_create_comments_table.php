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
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User who commented
            $table->foreignId('news_id')->constrained()->onDelete('cascade'); // News article being commented on
            $table->unsignedBigInteger('parent_id')->nullable(); // For replies
            $table->text('content'); // The comment body
            $table->timestamps();

            // Foreign key constraint for replies (parent_id references id on the same table)
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
