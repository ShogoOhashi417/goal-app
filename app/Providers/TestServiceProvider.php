<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // app()->singleton('testService', 'App\TestClasses\Test');
        // app()->singleton('App\TestClasses\TestInterface', 'App\TestClasses\Test');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // echo 'BBaa';
    }
}
