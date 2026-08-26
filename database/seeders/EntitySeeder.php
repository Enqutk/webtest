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
                'name' => 'Juba Water Network Upgrade',
                'type' => EntityTypeEnum::project,
                'category' => 'Engineering',
                'description' => 'Pressurized network design and construction support for urban water distribution.',
                'order' => 1,
            ],
            [
                'name' => 'Regional Treatment Plant Study',
                'type' => EntityTypeEnum::project,
                'category' => 'Infrastructure',
                'description' => 'Feasibility and concept design for a high-capacity wastewater treatment facility.',
                'order' => 2,
            ],
            [
                'name' => 'Corridor Sanitation Masterplan',
                'type' => EntityTypeEnum::project,
                'category' => 'Consulting',
                'description' => 'Strategic sanitation planning for growing corridor communities.',
                'order' => 3,
            ],
            [
                'name' => 'Industrial Outfall Design',
                'type' => EntityTypeEnum::project,
                'category' => 'Engineering',
                'description' => 'Outfall sewer design and supervision for an industrial development zone.',
                'order' => 4,
            ],
            [
                'name' => 'Ministry of Infrastructure',
                'type' => EntityTypeEnum::client,
                'category' => null,
                'description' => 'Public sector client',
                'order' => 10,
            ],
            [
                'name' => 'Urban Water Authority',
                'type' => EntityTypeEnum::partner,
                'category' => null,
                'description' => 'Delivery partner',
                'order' => 11,
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
