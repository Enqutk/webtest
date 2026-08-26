<?php

namespace Database\Seeders;

use App\Models\ContentBlock;
use App\Models\PageSection;
use App\Models\User;
use Illuminate\Database\Seeder;

class AboutContentSeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::query()->value('id');
        $sectionId = PageSection::query()->value('id');
        $base = public_path('assets/images/majiworks');

        $about = ContentBlock::query()->updateOrCreate(
            ['slug' => 'veritas-afrika-co-ltd'],
            [
                'section_id' => ContentBlock::query()->where('slug', 'veritas-afrika-co-ltd')->value('section_id') ?? $sectionId,
                'type' => 'image',
                'title' => 'Water expertise for living landscapes',
                'subtitle' => 'Who we are',
                'short_description' => '',
                'content' => '<p>MajiWorks is a Nairobi-based consultancy for climate-smart irrigation, rural WASH, flood resilience, and water-resource GIS. We work with counties, cooperatives, NGOs, and utilities to turn field data into schemes that communities can operate for years.</p>',
                'display_order' => 2,
                'is_active' => true,
                'created_by' => $userId,
                'updated_by' => $userId,
            ]
        );

        $this->replaceImage($about, $base.'/maji-about-field.png');

        ContentBlock::query()->updateOrCreate(
            ['slug' => 'key-features'],
            [
                'section_id' => ContentBlock::query()->where('slug', 'key-features')->value('section_id') ?? $sectionId,
                'type' => 'list',
                'title' => 'How we work',
                'list_items' => [
                    [
                        'title' => 'Field-first design',
                        'icon' => 'bi bi-compass',
                        'description' => 'Hydrology, soils, and community routines drive every drawing — not desk assumptions.',
                    ],
                    [
                        'title' => 'Buildable packages',
                        'icon' => 'bi bi-hammer',
                        'description' => 'Specs that local contractors can price, build, and maintain with available spare parts.',
                    ],
                    [
                        'title' => 'Climate-aware',
                        'icon' => 'bi bi-cloud-sun',
                        'description' => 'Drought, flood, and energy constraints are designed in from the first concept note.',
                    ],
                    [
                        'title' => 'After the ribbon',
                        'icon' => 'bi bi-people',
                        'description' => 'Governance coaching and O&amp;M tools so schemes keep running past the grant cycle.',
                    ],
                ],
                'display_order' => 1,
                'is_active' => true,
                'created_by' => $userId,
                'updated_by' => $userId,
            ]
        );

        $practice = ContentBlock::query()->updateOrCreate(
            ['slug' => 'about-section-1'],
            [
                'section_id' => ContentBlock::query()->where('slug', 'about-section-1')->value('section_id') ?? $sectionId,
                'type' => 'image',
                'title' => 'Our practice',
                'subtitle' => 'About Us',
                'content' => '<p>Our team blends hydrogeology, irrigation agronomy, WASH engineering, GIS, and community governance. We specialise in schemes that stretch scarce water further — solar pumping, drip networks, wetlands, and drainage that respects rivers.</p>',
                'display_order' => 6,
                'is_active' => true,
                'created_by' => $userId,
                'updated_by' => $userId,
            ]
        );
        $this->replaceImage($practice, $base.'/maji-service-irrigation.png');

        $approach = ContentBlock::query()->updateOrCreate(
            ['slug' => 'about-section-2'],
            [
                'section_id' => ContentBlock::query()->where('slug', 'about-section-2')->value('section_id') ?? $sectionId,
                'type' => 'image',
                'title' => 'Our approach',
                'subtitle' => 'About Us',
                'content' => '<p>Every engagement starts with listening — to farmers, operators, and county staff. We map what exists, sketch options people can afford, supervise construction carefully, and leave behind roles and tools that keep water flowing.</p>',
                'display_order' => 7,
                'is_active' => true,
                'created_by' => $userId,
                'updated_by' => $userId,
            ]
        );
        $this->replaceImage($approach, $base.'/maji-service-governance.png');
    }

    private function replaceImage(ContentBlock $block, string $path): void
    {
        if (! is_file($path)) {
            return;
        }

        $block->clearMediaCollection('images');
        $block->addMedia($path)
            ->preservingOriginal()
            ->toMediaCollection('images');
    }
}
