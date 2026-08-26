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

        $about = ContentBlock::query()->updateOrCreate(
            ['slug' => 'veritas-afrika-co-ltd'],
            [
                'section_id' => ContentBlock::query()->where('slug', 'veritas-afrika-co-ltd')->value('section_id') ?? $sectionId,
                'type' => 'image',
                'title' => 'Built for lasting infrastructure',
                'subtitle' => 'Who we are',
                'short_description' => '',
                'content' => '<p>Veritas Afrika is a multi-disciplinary consultancy of professional engineers and advisors. We support government, NGO, and private-sector clients with civil engineering and water infrastructure — from early planning through design and construction supervision.</p>',
                'display_order' => 2,
                'is_active' => true,
                'created_by' => $userId,
                'updated_by' => $userId,
            ]
        );

        $this->attachImage($about, public_path('assets/images/homepage-2/about-img-01.png'));

        ContentBlock::query()->updateOrCreate(
            ['slug' => 'key-features'],
            [
                'section_id' => ContentBlock::query()->where('slug', 'key-features')->value('section_id') ?? $sectionId,
                'type' => 'list',
                'title' => 'Key Features',
                'list_items' => [
                    [
                        'title' => 'Professional practice',
                        'icon' => 'bi bi-shield-check',
                        'description' => 'Experienced engineers and advisors recognized for practical delivery.',
                    ],
                    [
                        'title' => 'Client-first delivery',
                        'icon' => 'bi bi-people',
                        'description' => 'Clear communication, scoped solutions, and accountable milestones.',
                    ],
                    [
                        'title' => 'Regional impact',
                        'icon' => 'bi bi-globe-europe-africa',
                        'description' => 'Infrastructure designed for local conditions and long-term use.',
                    ],
                    [
                        'title' => 'End-to-end support',
                        'icon' => 'bi bi-diagram-3',
                        'description' => 'From studies and design to supervision on site.',
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
                'content' => '<p>We specialize in civil works with a strong focus on water and sanitation systems — pressurized networks, bulk supply, treatment plants, and open-channel sewer design. Our team pairs technical depth with project management discipline.</p>',
                'display_order' => 6,
                'is_active' => true,
                'created_by' => $userId,
                'updated_by' => $userId,
            ]
        );
        $this->attachImage($practice, public_path('assets/images/homepage-2/about-img-01.png'));

        $approach = ContentBlock::query()->updateOrCreate(
            ['slug' => 'about-section-2'],
            [
                'section_id' => ContentBlock::query()->where('slug', 'about-section-2')->value('section_id') ?? $sectionId,
                'type' => 'image',
                'title' => 'Our approach',
                'subtitle' => 'About Us',
                'content' => '<p>Every engagement starts with listening. We translate complex briefs into buildable designs, stay present through supervision, and measure success by systems that communities can rely on for years.</p>',
                'display_order' => 7,
                'is_active' => true,
                'created_by' => $userId,
                'updated_by' => $userId,
            ]
        );
        $this->attachImage($approach, public_path('assets/images/banner-slider-img/slider3-04.jpg'));
    }

    private function attachImage(ContentBlock $block, string $path): void
    {
        if (! is_file($path) || $block->getFirstMedia('images')) {
            return;
        }

        $block->addMedia($path)
            ->preservingOriginal()
            ->toMediaCollection('images');
    }
}
