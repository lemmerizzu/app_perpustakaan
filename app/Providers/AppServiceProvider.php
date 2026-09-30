<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
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
        // Pakai view pagination sendiri, karena view bawaan Laravel memakai kelas Tailwind
        // sedangkan layout aplikasi ini memakai CSS biasa.
        Paginator::defaultView('pagination::custom');
        Paginator::defaultSimpleView('pagination::custom');
    }
}
