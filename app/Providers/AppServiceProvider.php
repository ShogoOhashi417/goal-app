<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\Test;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // app()->singleton('App\Http\Controllers\Test', function ($app) {
        //     $test = new Test('わっはっは');
        //     return $test;
        // });
        app()->bind('App\Http\Controllers\TestInterface', 'App\Http\Controllers\Test');

        // app()->when('App\Http\Controllers\Test')
        //     ->needs('$id')
        //     ->give('わっしょい');
    }
}
