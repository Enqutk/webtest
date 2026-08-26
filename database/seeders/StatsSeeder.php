<?php

namespace Database\Seeders;

use App\Models\ContentBlock;
use App\Models\PageSection;
use App\Models\User;
use Illuminate\Database\Seeder;

class StatsSeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::query()->value('id');
        $sectionId = PageSection::query()->value('id');

        if (!$sectionId) {
            return;
        }

        ContentBlock::query()->updateOrCreate(
            ['slug' => 'stats'],
            [
                'section_id' => $sectionId,
                'type' => 'list',
                'title' => 'Impact Stats',
                'subtitle' => 'By the numbers',
                'list_items' => [
                    ['label' => 'Projects delivered', 'value' => 48, 'suffix' => '+'],
                    ['label' => 'Years of practice', 'value' => 12, 'suffix' => '+'],
                    ['label' => 'Specialists', 'value' => 25, 'suffix' => '+'],
                    ['label' => 'Partner agencies', 'value' => 18, 'suffix' => '+'],
                ],
                'display_order' => 8,
                'is_active' => true,
                'created_by' => $userId,
                'updated_by' => $userId,
            ]
        );
    }
}
