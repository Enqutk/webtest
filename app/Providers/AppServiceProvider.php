<?php

namespace App\Providers;

use App\Enums\StatusEnum;
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

            $contactsByType = OrganizationContact::where('status',StatusEnum::active)
                ->get()
                ->groupBy('type');
            $email = $contactsByType->get('email', collect())->pluck('value')->all();
            $phone = $contactsByType->get('phone', collect())->pluck('value')->all();
            $fax = $contactsByType->get('fax', collect())->pluck('value')->all();


            // Fetch all active hero feature blocks (adjust filter as needed)
            $heroFeatures = ContentBlock::where('is_active', true)
                ->where('title', 'Key Features')
                ->get()
                ->map(function ($block) {
                    $block->list_items = is_array($block->list_items)
                        ? $block->list_items
                        : json_decode($block->list_items, true);
                    return $block;
                });

            // Fetch About Us features block(s)
            $aboutFeatures = ContentBlock::where('is_active', true)
                ->where('section_id', 1) // Assuming section_id 1 is for About Us features
                ->get()
                ->map(function ($block) {
                    $block->list_items = is_array($block->list_items)
                        ? $block->list_items
                        : json_decode($block->list_items, true);
                    return [
                        'title' => $block->title,
                        'subtitle' => $block->subtitle,
                        'short_description' => $block->short_description,
                        'list_items' => $block->list_items,
                    ];
                });

            $data = array_merge(
                ['email' => $email, 'phone' => $phone, 'fax' => $fax],
                ['address' => $address, 'working_days' => $working_days, 'map' => $map],
                ['heroFeatures' => $heroFeatures ,'aboutFeatures' => $aboutFeatures]
            );

            $view->with(compact('data'));
        });
    }
};
