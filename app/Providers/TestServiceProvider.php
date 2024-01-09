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
        app()->singleton('testService', 'App\Http\Controllers\Test');
        app()->singleton('App\Http\Controllers\TestInterface', 'App\Http\Controllers\Test');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        echo 'BB';
        
    }
}
