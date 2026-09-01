<?php

namespace Database\Seeders;

use App\Models\Hero;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class HomePageSeeder extends Seeder
{
    public function run(): void
    {
        $organization = Organization::query()->firstOrCreate([], [
            'title' => 'Maji Works',
            'status' => 'active',
        ]);

        // Load existing hero slide images from Hero records if available
        $hero1 = Hero::query()->where('order', 1)->first();
        $hero2 = Hero::query()->where('order', 2)->first();
        $hero3 = Hero::query()->where('order', 3)->first();

        $heroImg1 = $hero1?->getFirstMedia('image') ? 'heros/image/' . $hero1->getFirstMedia('image')->file_name : 'heros/image/maji-hero-irrigation.png';
        $heroImg2 = $hero2?->getFirstMedia('image') ? 'heros/image/' . $hero2->getFirstMedia('image')->file_name : 'heros/image/maji-hero-wash.png';
        $heroImg3 = $hero3?->getFirstMedia('image') ? 'heros/image/' . $hero3->getFirstMedia('image')->file_name : 'heros/image/maji-hero-flood.png';

        $homeSections = [
            'hero' => [
                'is_visible' => true,
                'badge' => 'Infrastructure · Engineering · Impact',
                'title' => 'Building resilient infrastructure for lasting communities',
                'subtitle' => 'Engineering Excellence',
                'description' => 'We design, engineer, and deliver high-impact water and infrastructure systems that power communities across East Africa.',
                'cta_text' => 'Explore Our Work',
                'cta_url' => '/portfolio',
                'secondary_cta_text' => 'Our Services',
                'secondary_cta_url' => '/our-services',
                'slides' => [
                    [
                        'title' => 'Water systems that feed people',
                        'subtitle' => 'Irrigation · WASH · Resilience',
                        'description' => 'MajiWorks designs climate-smart irrigation, rural water, and drainage schemes that communities can operate long after handover.',
                        'image' => [$heroImg1 => $heroImg1],
                        'text_link' => 'Explore services',
                        'button_link' => '/our-services',
                        'is_visible' => true,
                    ],
                    [
                        'title' => 'Safe water closer to home',
                        'subtitle' => 'Rural WASH practice',
                        'description' => 'From protected springs to town kiosks — practical WASH infrastructure sized for real demand and local spare parts.',
                        'image' => [$heroImg2 => $heroImg2],
                        'text_link' => 'See projects',
                        'button_link' => '/portfolio',
                        'is_visible' => true,
                    ],
                    [
                        'title' => 'Towns that stay dry when rivers rise',
                        'subtitle' => 'Flood & drainage',
                        'description' => 'We plan drains, culverts, and wetland buffers so roads, markets, and homes stay usable through flood seasons.',
                        'image' => [$heroImg3 => $heroImg3],
                        'text_link' => 'Start a project',
                        'button_link' => '/contact',
                        'is_visible' => true,
                    ],
                ],
            ],
            'about' => [
                'is_visible' => true,
                'eyebrow' => 'Who we are',
                'title' => 'Water expertise for living landscapes',
                'description' => 'We combine technical hydrology, sustainable agriculture, and community governance to design water infrastructure that lasts generations.',
                'points' => [
                    [
                        'title' => 'Design & Build',
                        'description' => 'Turnkey irrigation schemes, boreholes, and piped distribution networks engineered for rural and urban resilience.',
                    ],
                    [
                        'title' => 'Climate Resilience',
                        'description' => 'Flood control, catchment rehabilitation, and water harvesting structures that withstand changing weather patterns.',
                    ],
                    [
                        'title' => 'Governance & Training',
                        'description' => 'Capacity building for community water management committees, scheme operators, and county water utilities.',
                    ],
                ],
            ],
            'services' => [
                'is_visible' => true,
                'eyebrow' => 'What we deliver',
                'title' => 'Specialized engineering across the water cycle',
                'description' => 'From feasibility studies and design to construction supervision and long-term asset management.',
                'cta_text' => 'View all services',
                'cta_url' => '/our-services',
            ],
            'stats' => [
                'is_visible' => true,
                'eyebrow' => 'By the numbers',
                'title' => 'Impact that compounds across communities',
                'subtitle' => 'Measured across 10+ years of active field engineering across East Africa.',
                'items' => [
                    [
                        'value' => '25+',
                        'label' => 'Counties served',
                        'subtext' => 'Across Kenya & East Africa',
                    ],
                    [
                        'value' => '140k+',
                        'label' => 'People with improved water',
                        'subtext' => 'Clean piped drinking supply',
                    ],
                    [
                        'value' => '18k+',
                        'label' => 'Hectares irrigated',
                        'subtext' => 'High-efficiency gravity schemes',
                    ],
                    [
                        'value' => '98%',
                        'label' => 'Infrastructure uptime',
                        'subtext' => 'At 24-month post-handover audit',
                    ],
                ],
            ],
            'portfolio' => [
                'is_visible' => true,
                'eyebrow' => 'Selected projects',
                'title' => 'Proven field outcomes',
                'description' => 'A curated selection of completed irrigation networks, piped water supply schemes, and catchment works.',
                'cta_text' => 'View full portfolio',
                'cta_url' => '/portfolio',
            ],
            'clients' => [
                'is_visible' => true,
                'eyebrow' => 'Trusted partners',
                'title' => 'Organizations that build with us',
                'description' => 'We collaborate with county governments, international development partners, water service providers, and agricultural enterprises.',
            ],
            'team' => [
                'is_visible' => true,
                'eyebrow' => 'Our leadership',
                'title' => 'The team behind the work',
                'description' => 'Senior hydrologists, civil engineers, GIS specialists, and community engagement leads.',
                'cta_text' => 'Meet our full team',
                'cta_url' => '/about#team',
            ],
            'cta' => [
                'is_visible' => true,
                'title' => 'Ready to engineer lasting water solutions?',
                'description' => 'Whether you are planning a large irrigation scheme or a community WASH system, our team is ready to assist.',
                'button_text' => 'Start a conversation',
                'button_url' => '/contact',
            ],
        ];

        $currentTheme = is_array($organization->theme) ? $organization->theme : Organization::defaultTheme();
        $currentTheme['home_sections'] = $homeSections;

        $organization->theme = $currentTheme;
        $organization->save();
    }
}
