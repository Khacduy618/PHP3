<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Lấy danh sách categories
        $categories = DB::table("categories")->select('id', 'name', 'slug', 'parent_id')->orderBy('id', 'asc')->limit(6)->get();

        // Chia sẻ biến categories với tất cả các view
        View::share('categories', $categories);
    }
}
