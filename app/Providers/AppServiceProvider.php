<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Paginator::useBootstrap();

        View::composer('frontend.*', function ($view) {
            $view->with('navCategories', Category::where('is_active', true)
                ->orderBy('sort_order')
                ->get());
        });
    }
}