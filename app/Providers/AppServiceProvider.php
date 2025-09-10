<?php

namespace App\Providers;

use App\Models\Page;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use App\Models\Route_link;

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
        Vite::prefetch(concurrency: 3);

        // Share links globally with Inertia
        Inertia::share([
            'links' => function () {
                return Route_link::with('children')
                    ->whereNull('parent_id')
                    ->where('visibility', 'public')
                    ->get();
            },

            'admin_links' => function () {
                if (auth()->check() && auth()->user()) {
                    return Route_link::with('children')
                        ->whereNull('parent_id')
                        ->where('visibility', 'admin')
                        ->get();
                }
                return collect(); // empty if not admin
            },


        ]);
    }
}
