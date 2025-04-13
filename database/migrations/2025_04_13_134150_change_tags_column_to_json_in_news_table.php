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
        Schema::table('news', function (Blueprint $table) {
            // Change the tags column to JSON type
            // Note: Ensure your database supports JSON columns (MySQL 5.7+, PostgreSQL 9.2+)
            // This will cause loss of existing tag data. Back up if needed.
            // Set existing data to NULL first to avoid conversion errors.
            DB::table('news')->update(['tags' => null]);
            // Now change the column type to JSON
            $table->json('tags')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            // Revert back to TEXT or VARCHAR if needed
            // Data loss might occur if JSON cannot be cast back to string simply.
            $table->text('tags')->nullable()->change();
        });
    }
};
