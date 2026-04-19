<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        $forceHttps = filter_var((string) env('FORCE_HTTPS', 'true'), FILTER_VALIDATE_BOOL);

        if (app()->environment('production') && $forceHttps) {
            URL::forceScheme('https');
        }
    }
}
