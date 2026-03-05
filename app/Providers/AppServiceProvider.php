<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
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
        Paginator::useBootstrap();

        View::composer('partials.header', function ($view): void {
            $cartCount = collect(session('cart', []))
                ->sum(fn (array $item): int => (int) ($item['quantity'] ?? 0));

            $view->with('cartCount', $cartCount);
        });
    }
}
