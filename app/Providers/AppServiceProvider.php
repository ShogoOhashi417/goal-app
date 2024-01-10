<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\TestClasses\Test;

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
        // app()->singleton('App\TestClasses\Test', function ($app) {
        //     $test = new Test('わっはっは');
        //     return $test;
        // });
        app()->bind('App\TestClasses\TestInterface', 'App\TestClasses\Test');

        // app()->when('App\TestClasses\Test')
        //     ->needs('$id')
        //     ->give('わっしょい');
    }
}
