<?php

namespace App\Providers;

use App\Models\MenuItem;
use App\Models\MenuLocation;
use App\Observers\MenuCacheObserver;
use App\Services\HomeContentService;
use App\Services\NavigationService;
use App\MediaLibrary\ModelNamePathGenerator;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Page::stickyFormActions(true);
        CreateRecord::stickyFormActions(true);
        EditRecord::stickyFormActions(true);

        app()->bind(PathGenerator::class, function () {
            return new ModelNamePathGenerator();
        });

        MenuItem::observe(MenuCacheObserver::class);
        MenuLocation::observe(MenuCacheObserver::class);

        RateLimiter::for('contact', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        View::composer([
            'index',
            'about',
            'contact',
            'services.*',
            'portfolio.*',
            'pages.*',
            'emails.contact',
            'layouts.*',
            'components.*',
        ], function ($view) {
            $view->with([
                'data' => app(HomeContentService::class)->getHomeContent(),
                'navItems' => app(NavigationService::class)->navbarItems(),
            ]);
        });
    }
}
