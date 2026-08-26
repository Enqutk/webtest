<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Models\Hero;
use App\Models\User;
use Illuminate\Database\Seeder;

class HeroSeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::query()->value('id');
        $base = public_path('assets/images/majiworks');

        $slides = [
            [
                'title' => 'Water systems that feed people',
                'subtitle' => 'Irrigation · WASH · Resilience',
                'description' => 'MajiWorks designs climate-smart irrigation, rural water, and drainage schemes that communities can operate long after handover.',
                'button_link' => '/our-services',
                'text_link' => 'Explore services',
                'order' => 1,
                'image' => $base.'/maji-hero-irrigation.png',
            ],
            [
                'title' => 'Safe water closer to home',
                'subtitle' => 'Rural WASH practice',
                'description' => 'From protected springs to town kiosks — practical WASH infrastructure sized for real demand and local spare parts.',
                'button_link' => '/portfolio',
                'text_link' => 'See projects',
                'order' => 2,
                'image' => $base.'/maji-hero-wash.png',
            ],
            [
                'title' => 'Towns that stay dry when rivers rise',
                'subtitle' => 'Flood & drainage',
                'description' => 'We plan drains, culverts, and wetland buffers so roads, markets, and homes stay usable through flood seasons.',
                'button_link' => '/contact',
                'text_link' => 'Start a project',
                'order' => 3,
                'image' => $base.'/maji-hero-flood.png',
            ],
        ];

        foreach ($slides as $slide) {
            $imagePath = $slide['image'];
            unset($slide['image']);

            $hero = Hero::query()->updateOrCreate(
                ['order' => $slide['order']],
                [
                    ...$slide,
                    'status' => StatusEnum::active,
                    'created_by' => $userId,
                    'updated_by' => $userId,
                ]
            );

            if (is_file($imagePath)) {
                $hero->clearMediaCollection('image');
                $hero->addMedia($imagePath)
                    ->preservingOriginal()
                    ->toMediaCollection('image');
            }
        }
    }
}
