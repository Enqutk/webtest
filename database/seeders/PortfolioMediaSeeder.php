<?php

namespace Database\Seeders;

use App\Enums\EntityTypeEnum;
use App\Models\Entity;
use Illuminate\Database\Seeder;

class PortfolioMediaSeeder extends Seeder
{
    public function run(): void
    {
        $base = public_path('assets/images/majiworks');

        $byName = [
            'Rift Valley Solar Drip Pilot' => $base.'/maji-service-solar.png',
            'Lake Basin Wetland Treatment' => $base.'/maji-project-wetland.png',
            'Highland Canal Rehabilitation' => $base.'/maji-project-highland.png',
            'Coastal Mangrove Buffer Plan' => $base.'/maji-project-coast.png',
            'County Water GIS Inventory' => $base.'/maji-service-gis.png',
            'School WASH Package — 40 Sites' => $base.'/maji-service-wash.png',
        ];

        foreach ($byName as $name => $path) {
            $project = Entity::query()
                ->where('type', EntityTypeEnum::project)
                ->where('name', $name)
                ->first();

            if (! $project || ! is_file($path)) {
                continue;
            }

            $project->clearMediaCollection('image');
            $project->addMedia($path)
                ->preservingOriginal()
                ->toMediaCollection('image');
        }
    }
}
