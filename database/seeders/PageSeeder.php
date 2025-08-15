<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\ContentBlock;
use App\Models\User;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        // Get the first user for created_by
        $user = User::first();
        
        if (!$user) {
            $this->command->error('No users found. Please run UserSeeder first.');
            return;
        }
        
        // Create Home page
        $homePage = Page::create([
            'title' => 'Home',
            'slug' => 'home',
            'short_description' => 'Welcome to Veritas Afrika - Empowering Your Business',
            'is_active' => true,
            'display_order' => 0,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);


        // Create section for Home page (Features)
        $heroFeatures = PageSection::create([
            'page_id' => $homePage->id,
            'title' => 'hero Features',
            'subtitle' => 'Discover Our Key Features',
            'display_order' => 1,
            'is_active' => true,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create content block for Home page features (as a list)
        ContentBlock::create([
            'section_id' => $heroFeatures->id,
            'type' => 'list',
            'title' => 'Key Features',
            'list_items' =>[
            [
                'title' => 'Professionalism',
                'icon' => 'bi bi-shield-check', 
                'description' => 'Our team consists of experienced leaders recognized regionally and...',
            ],
            [
                'title' => 'Client-Centric Approach',
                'icon' => 'bi bi-person-heart',
                'description' => 'Getting our clients what they deserve is our mission. We prioritize...',
            ],
            [
                'title' => 'Regional Impact',
                'icon' => 'bi bi-globe',
                'description' => 'We address local development challenges using effective...',
            ],
            ],
            'display_order' => 1,
            'is_active' => true,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);



    }
}
