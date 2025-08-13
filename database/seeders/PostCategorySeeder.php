<?php

namespace Database\Seeders;

use App\Models\PostCategory;
use Illuminate\Database\Seeder;

class PostCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Water & Environment',
            'Team & Expertise'
        ];

        foreach ($categories as $categoryName) {
            PostCategory::firstOrCreate(
                ['name' => $categoryName],
                [
                    'name' => $categoryName,
                    'slug' => \Illuminate\Support\Str::slug($categoryName),
                ]
            );
        }
    }
}
