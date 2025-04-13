<?php

namespace App\Providers;

use App\View\Composers\MenuComposer; // Import the composer
use Illuminate\Support\Facades\View; // Import the View facade
use Illuminate\Support\ServiceProvider;

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
        // Register the MenuComposer for multiple views (client menu and admin forms)
        View::composer(
            [
                'client.blocks.menu',
                'admin.category.add',
                'admin.news.add',
                'admin.category.edit', // Added edit view
                'admin.news.edit'      // Added edit view
            ],
            MenuComposer::class
        );
    }
}
