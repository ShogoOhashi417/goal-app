<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\TestService\TestService;

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
        app()->bind('App\TestService\TestServiceInterface',
        'App\TestService\TestService');
    }
}
