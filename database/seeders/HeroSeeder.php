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

        $slides = [
            [
                'title' => 'Infrastructure with clarity',
                'subtitle' => 'Civil engineering & consultancy',
                'description' => 'Multi-disciplinary consultancy delivering water, sanitation, and civil infrastructure with clarity, craft, and conviction.',
                'button_link' => '/our-services',
                'text_link' => 'Explore services',
                'order' => 1,
                'image' => public_path('assets/images/banner-slider-img/slider2-04.jpg'),
            ],
            [
                'title' => 'Systems that serve communities',
                'subtitle' => 'Water & sanitation',
                'description' => 'From bulk supply and treatment plants to pressurized networks — designed for growing cities and lasting performance.',
                'button_link' => '/portfolio',
                'text_link' => 'View portfolio',
                'order' => 2,
                'image' => public_path('assets/images/banner-slider-img/slider3-04.jpg'),
            ],
            [
                'title' => 'Partners from concept to delivery',
                'subtitle' => 'Project excellence',
                'description' => 'We work with government, NGO, and private clients to turn complex infrastructure briefs into buildable, supervised outcomes.',
                'button_link' => '/contact',
                'text_link' => 'Start a project',
                'order' => 3,
                'image' => public_path('assets/images/homepage-2/about-img-01.png'),
            ],
        ];

        foreach ($slides as $slide) {
            $imagePath = $slide['image'];
            unset($slide['image']);

            $hero = Hero::query()->updateOrCreate(
                ['title' => $slide['title']],
                [
                    ...$slide,
                    'status' => StatusEnum::active,
                    'created_by' => $userId,
                    'updated_by' => $userId,
                ]
            );

            if (is_file($imagePath) && ! $hero->getFirstMedia('image')) {
                $hero->addMedia($imagePath)
                    ->preservingOriginal()
                    ->toMediaCollection('image');
            }
        }
    }
}
