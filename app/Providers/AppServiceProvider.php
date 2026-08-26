<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;
use App\MediaLibrary\ModelNamePathGenerator;
use App\Services\HomeContentService;
use Illuminate\Support\Facades\View;

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


        View::composer([
            'index',
            'about',
            'contact',
            'services.index',
            'services.show',
            'portfolio.index',
            'portfolio.show',
            'layouts.horizon.footer',
            'layouts.app',
        ], function ($view) {
            $data = app(HomeContentService::class)->getHomeContent();
            $view->with(compact('data'));
        });
    }
}
