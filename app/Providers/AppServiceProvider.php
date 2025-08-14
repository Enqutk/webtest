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


    View::composer(['index', 'about','contact', 'services'], function ($view) {
        $organization = Organization::first();

        $address = $organization->address ?? null;
        $working_days = $organization->opening_hours ?? [];
        $map = $organization->map_url ?? null;

        $email = OrganizationContact::where('type', 'email')->pluck('value')->toArray();
        $phone = OrganizationContact::where('type', 'phone')->pluck('value')->toArray();
        $fax = OrganizationContact::where('type', 'fax')->pluck('value')->toArray();
        $data = ['email' => $email, 'phone' => $phone, 'fax' => $fax] + 
                ['address' => $address, 'working_days' => $working_days, 'map' => $map];
        $view->with(compact('data'));
    });


    }
}
