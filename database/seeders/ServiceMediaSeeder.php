<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceMediaSeeder extends Seeder
{
    public function run(): void
    {
        $base = public_path('assets/images/majiworks');

        $bySlug = [
            'climate-smart-irrigation' => $base.'/maji-service-irrigation.png',
            'rural-wash-systems' => $base.'/maji-service-wash.png',
            'flood-drainage-resilience' => $base.'/maji-hero-flood.png',
            'water-resource-gis' => $base.'/maji-service-gis.png',
            'solar-water-pumping' => $base.'/maji-service-solar.png',
            'community-water-governance' => $base.'/maji-service-governance.png',
        ];

        foreach ($bySlug as $slug => $path) {
            $service = Service::query()->where('slug', $slug)->first();

            if (! $service || ! is_file($path)) {
                continue;
            }

            $service->clearMediaCollection('main_image');
            $service->clearMediaCollection('secondary_image');

            $service->addMedia($path)
                ->preservingOriginal()
                ->toMediaCollection('main_image');

            $service->addMedia($path)
                ->preservingOriginal()
                ->toMediaCollection('secondary_image');
        }
    }
}
