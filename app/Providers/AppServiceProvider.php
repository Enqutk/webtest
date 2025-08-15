<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;
use App\MediaLibrary\ModelNamePathGenerator;
use App\Models\ContentBlock;
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


        View::composer(['index', 'about', 'contact', 'services', 'hero-features'], function ($view) {
            $organization = Organization::first();
            $address = $organization->address ?? null;
            $working_days = $organization->opening_hours ?? [];
            $map = $organization->map_url ?? null;

            $contactsByType = OrganizationContact::where('status', \App\Enums\StatusEnum::active)
                ->get()
                ->groupBy('type');
            $email = $contactsByType->get('email', collect())->pluck('value')->all();
            $phone = $contactsByType->get('phone', collect())->pluck('value')->all();
            $fax = $contactsByType->get('fax', collect())->pluck('value')->all();

            // Fetch homepage hero section content block
            $heroFeatures = ContentBlock::where('title', 'Key Features')
                ->where('display_order', 1)
                ->first();

            $data = array_merge(
                ['email' => $email, 'phone' => $phone, 'fax' => $fax],
                ['address' => $address, 'working_days' => $working_days, 'map' => $map],
                ['heroFeatures' => $heroFeatures]
            );

            $view->with(compact('data'));
        });
    }
};
