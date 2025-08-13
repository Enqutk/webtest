<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@admin.com')->first();
        $category = PostCategory::first();

        if (!$admin || !$category) {
            return;
        }

        $posts = [
            [
                'title' =>  'Delivering Excellence, One Drop at a Time: The Veritas Afrika Approach to Water',
                'short_description' => 'Learn the basics of Laravel framework and start building modern web applications with PHP.',
                'content' => '<p>In a world where water is our most precious resource, the infrastructure we build to manage it is more critical than ever. At Veritas Afrika, we believe in delivering excellence, one drop at a time. Our team of expert hydraulic and environmental engineers specializes in designing and managing sustainable water systems, from bulk supply and purification to sanitation networks. We don\'t just build infrastructure; we build solutions that are reliable, efficient, and designed to serve communities for generations to come.</p>',
                'tags' => 'Water, Environment, Infrastructure, Sustainable, Engineering',
                'is_active' => true,
            ],
        ];

        foreach ($posts as $postData) {
            Post::firstOrCreate(
                ['title' => $postData['title']],
                array_merge($postData, [
                    'category_id' => $category->id,
                    'created_by' => $admin->id,
                    'updated_by' => $admin->id,
                ])
            );
        }
    }
}
