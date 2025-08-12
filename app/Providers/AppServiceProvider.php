<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;
use App\MediaLibrary\ModelNamePathGenerator;

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
        // Register custom path generator globally for Spatie Media Library
        app()->bind(PathGenerator::class, function () {
            return new ModelNamePathGenerator();
        });
    }
}
