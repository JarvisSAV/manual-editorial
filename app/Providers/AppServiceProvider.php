<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        // force https
        // si no estas trabajando con https, comenta estas lineas
        URL::forceScheme('https');
        URL::forceRootUrl(config('app.url'));
    }
}
