<?php

namespace Database\Seeders;

use App\Enums\EntityTypeEnum;
use App\Enums\StatusEnum;
use App\Models\Entity;
use App\Models\User;
use Illuminate\Database\Seeder;

class EntitySeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::query()->value('id');

        $items = [
            [
                'name' => 'Rift Valley Solar Drip Pilot',
                'type' => EntityTypeEnum::project,
                'category' => 'Irrigation',
                'description' => '120-hectare solar drip scheme for a smallholder cooperative, with training and O&M manuals.',
                'order' => 1,
            ],
            [
                'name' => 'Lake Basin Wetland Treatment',
                'type' => EntityTypeEnum::project,
                'category' => 'WASH',
                'description' => 'Constructed wetland polishing stage for a growing lakeside town, designed for low power and local maintenance.',
                'order' => 2,
            ],
            [
                'name' => 'Highland Canal Rehabilitation',
                'type' => EntityTypeEnum::project,
                'category' => 'Irrigation',
                'description' => 'Lining and flow-control upgrades on a century-old gravity canal serving terrace farms.',
                'order' => 3,
            ],
            [
                'name' => 'Coastal Mangrove Buffer Plan',
                'type' => EntityTypeEnum::project,
                'category' => 'Resilience',
                'description' => 'Nature-based drainage and mangrove buffers protecting a coastal market road from seasonal floods.',
                'order' => 4,
            ],
            [
                'name' => 'County Water GIS Inventory',
                'type' => EntityTypeEnum::project,
                'category' => 'GIS',
                'description' => 'Full spatial inventory of rural water points, yields, and functionality for one county water office.',
                'order' => 5,
            ],
            [
                'name' => 'School WASH Package — 40 Sites',
                'type' => EntityTypeEnum::project,
                'category' => 'WASH',
                'description' => 'Standardised rainwater, handwashing, and sanitation blocks rolled out across forty schools.',
                'order' => 6,
            ],
            [
                'name' => 'East Africa Climate Fund',
                'type' => EntityTypeEnum::partner,
                'category' => null,
                'description' => 'Adaptation finance partner',
                'order' => 10,
            ],
            [
                'name' => 'Rift Agri Cooperative Union',
                'type' => EntityTypeEnum::client,
                'category' => null,
                'description' => 'Irrigation scheme client',
                'order' => 11,
            ],
            [
                'name' => 'County Water Office',
                'type' => EntityTypeEnum::client,
                'category' => null,
                'description' => 'Public sector WASH & GIS client',
                'order' => 12,
            ],
            [
                'name' => 'Blue Horizon NGO',
                'type' => EntityTypeEnum::partner,
                'category' => null,
                'description' => 'Rural WASH programme partner',
                'order' => 13,
            ],
            [
                'name' => 'Lakeside Municipality',
                'type' => EntityTypeEnum::client,
                'category' => null,
                'description' => 'Drainage & wetland client',
                'order' => 14,
            ],
            [
                'name' => 'SolarPump Africa',
                'type' => EntityTypeEnum::partner,
                'category' => null,
                'description' => 'Equipment & commissioning partner',
                'order' => 15,
            ],
        ];

        foreach ($items as $item) {
            Entity::query()->updateOrCreate(
                ['name' => $item['name']],
                [
                    ...$item,
                    'status' => StatusEnum::active,
                    'created_by' => $userId,
                    'updated_by' => $userId,
                ]
            );
        }
    }
}
