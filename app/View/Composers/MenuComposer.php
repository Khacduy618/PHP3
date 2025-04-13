<?php

namespace App\View\Composers;

use App\Models\Category;
use Illuminate\View\View;

class MenuComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // Fetch parent categories (status 'Hiện') with their active children (status 'Hiện')
        $menuCategories = Category::query()
            ->whereNull('parent_id') // Parent categories
            ->where('status', 'Hiện')   // Only active parent categories
            ->with([
                'children' => function ($query) {
                    $query->where('status', 'Hiện') // Only active child categories
                        ->orderBy('name'); // Order children alphabetically
                }
            ])
            ->orderBy('name') // Order parent categories alphabetically
            ->get();

        $view->with('menuCategories', $menuCategories);
    }
}
