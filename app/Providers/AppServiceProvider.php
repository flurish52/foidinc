<?php

namespace App\Providers;

use App\Models\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

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
        Inertia::share([
            'links' => function () {
                return Page::with('children:id,parent_id,title,slug')
                ->whereNull('parent_id')
                    ->where('status', 'published')
                    ->orderBy('position')
                    ->get(['id', 'title', 'slug', 'position']);
            },

        ]);
    }
}
