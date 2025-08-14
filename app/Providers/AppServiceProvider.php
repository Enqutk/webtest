<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;
use App\MediaLibrary\ModelNamePathGenerator;
use App\Models\Organization;
use App\Models\OrganizationContact;
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


    View::composer(['index', 'contact', 'services'], function ($view) {
        $address = Organization::first()->address ?? null;
        $email = OrganizationContact::where('type', 'email')->first()->value ?? null;
        $phone = OrganizationContact::where('type', 'phone')->first()->value ?? null;
        $data = ['email' => $email, 'phone' => $phone];
        $view->with(compact('address', 'data'));
    });


    }
}
