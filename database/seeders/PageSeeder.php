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

        // Create About Us page
        $aboutPage = Page::create([
            'title' => 'About Us',
            'slug' => 'about-us',
            'short_description' => 'Learn about our company, mission, and values',
            'is_active' => true,
            'display_order' => 1,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create sections for About Us page
        $missionSection = PageSection::create([
            'page_id' => $aboutPage->id,
            'title' => 'Our Mission',
            'subtitle' => 'Driving innovation and excellence',
            'display_order' => 1,
            'is_active' => true,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        $visionSection = PageSection::create([
            'page_id' => $aboutPage->id,
            'title' => 'Our Vision',
            'subtitle' => 'Building a better future',
            'display_order' => 2,
            'is_active' => true,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create content blocks for Mission section
        ContentBlock::create([
            'section_id' => $missionSection->id,
            'type' => 'text',
            'title' => 'Mission Statement',
            'content' => '<p>Our mission is to deliver exceptional value to our customers through innovative solutions and unwavering commitment to quality. We strive to exceed expectations in everything we do.</p>',
            'display_order' => 1,
            'is_active' => true,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create content blocks for Vision section
        ContentBlock::create([
            'section_id' => $visionSection->id,
            'type' => 'text',
            'title' => 'Vision Statement',
            'content' => '<p>We envision a future where our solutions empower businesses to achieve their full potential, creating lasting impact in the communities we serve.</p>',
            'display_order' => 1,
            'is_active' => true,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create Services page
        $servicesPage = Page::create([
            'title' => 'Our Services',
            'slug' => 'services',
            'short_description' => 'Comprehensive solutions tailored to your needs',
            'is_active' => true,
            'display_order' => 2,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create sections for Services page
        $mainServicesSection = PageSection::create([
            'page_id' => $servicesPage->id,
            'title' => 'Core Services',
            'subtitle' => 'What we do best',
            'display_order' => 1,
            'is_active' => true,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Create content blocks for Services section
        ContentBlock::create([
            'section_id' => $mainServicesSection->id,
            'type' => 'list',
            'title' => 'Service List',
            'content' => '<ul><li>Strategic Consulting</li><li>Digital Transformation</li><li>Technology Solutions</li><li>Project Management</li></ul>',
            'display_order' => 1,
            'is_active' => true,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

    }
}
