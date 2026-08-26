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

        Hero::query()->updateOrCreate(
            ['title' => 'Infrastructure with clarity'],
            [
                'subtitle' => 'Civil engineering & consultancy',
                'description' => 'Multi-disciplinary consultancy delivering civil engineering and infrastructure expertise across Africa.',
                'button_link' => '/our-services',
                'text_link' => 'Explore services',
                'order' => 1,
                'status' => StatusEnum::active,
                'created_by' => $userId,
                'updated_by' => $userId,
            ]
        );
    }
}
