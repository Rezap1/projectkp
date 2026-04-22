<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // Tambahkan ini

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Tambahkan logika ini
        if (str_contains(config('app.url'), 'ngrok-free.dev')) {
            URL::forceScheme('https');
        }
    }
}
