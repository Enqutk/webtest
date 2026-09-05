<?php

namespace Database\Seeders;

use App\Enums\EntityTypeEnum;
use App\Enums\StatusEnum;
use App\Models\Entity;
use App\Models\Hero;
use App\Models\Organization;
use App\Models\OrganizationContact;
use App\Models\Service;
use App\Models\SocialRef;
use App\Models\Team;
use Illuminate\Database\Seeder;

class EnkuTaddesseSeeder extends Seeder
{
    public function run(): void
    {
        $orgData = [
            'title' => 'Enku Taddesse',
            'slug' => 'enku-taddesse',
            'tagline' => 'Software Engineer & Full Stack Developer · Dire Dawa University',
            'meta_description' => 'Enku Taddesse — Full Stack Developer building useful, robust tools that solve real problems. Dire Dawa University, Ethiopia.',
            'po_box' => 'Dire Dawa University',
            'address' => 'Dire Dawa University, Dire Dawa, Ethiopia',
            'opening_hours' => [
                [
                    'days' => ['mon', 'tue', 'wed', 'thu', 'fri'],
                    'from' => '08:30:00',
                    'to' => '17:30:00',
                ],
            ],
            'status' => 'active',
            'theme' => [
                'bg' => '#0b0f19',
                'surface' => '#111827',
                'ink' => '#f9fafb',
                'muted' => '#9ca3af',
                'line' => '#1f2937',
                'accent' => '#eab308', // Gold accent matching her portfolio theme
                'accent_dark' => '#ca8a04',
                'accent_soft' => 'rgba(234, 179, 8, 0.15)',
                'dark' => '#030712',
                'font_display' => 'Outfit',
                'font_body' => 'Outfit',
                'brand_font_family' => 'Outfit',
                'brand_font_weight' => '700',
                'brand_letter_spacing' => '0.02em',
                'tagline_font_family' => 'Outfit',
                'tagline_font_style' => 'normal',
                'tagline_font_weight' => '500',
                'nav_font_family' => 'Outfit',
                'nav_font_weight' => '600',
                'nav_spacing' => '1.5rem',
                'image_shape' => 'squircle',
                'show_logo' => false,
                'show_brand_text' => true,
                'show_tagline' => true,
                'show_header_cta' => true,
                'header_cta_text' => 'Get in Touch',
                'show_address' => true,
                'show_po_box' => true,
                'show_opening_hours' => false,
                'show_email' => true,
                'show_phone' => true,
                'show_social_links' => true,
                'show_footer_credit' => true,
                'footer_credit_html' => 'Creator of <a href="/">Kimem Cards</a> — this platform.',
                'creator' => [
                    'is_visible' => true,
                    'label' => 'Creator of this platform',
                    'name' => 'Kimem Cards',
                    'line' => 'NFC smart cards and live digital profiles.',
                    'cta_text' => 'Visit Kimem',
                    'url' => '/',
                ],
                'home_sections' => [
                    'hero' => [
                        'is_visible' => true,
                        'badge' => 'Full Stack Developer · DDU ICT Club · Teter Trending PLC',
                        'subtitle' => 'Software Engineer & Project Lead',
                        'title' => 'Building clean, robust tools that solve real problems',
                        'description' => 'Software Engineer at Dire Dawa University with experience leading project delivery at Teter Trending PLC and coordinating core ICT initiatives.',
                        'cta_text' => 'Explore Projects',
                        'cta_url' => '/portfolio',
                        'secondary_cta_text' => 'About & Story',
                        'secondary_cta_url' => '/about',
                        'image_shape' => 'squircle',
                        'slides' => [
                            [
                                'eyebrow' => 'Full Stack Web & Mobile',
                                'title' => 'Crafting scalable web applications and community software',
                                'description' => 'From project management on enterprise client websites to building high-utility platforms like LegnaPath and Freelance Dire.',
                                'button_label' => 'View Projects',
                                'button_url' => '/portfolio',
                                'image_shape' => 'squircle',
                                'is_visible' => true,
                            ],
                            [
                                'eyebrow' => 'Leadership & Community',
                                'title' => 'Leading DDU ICT Club and mentoring junior developers',
                                'description' => 'Driving student innovation, technical workshops, and real-world software product engineering in Eastern Ethiopia.',
                                'button_label' => 'Direct Contact',
                                'button_url' => '/contact',
                                'image_shape' => 'squircle',
                                'is_visible' => true,
                            ],
                        ],
                    ],
                    'about' => [
                        'is_visible' => true,
                        'eyebrow' => 'My Story & Experience',
                        'title' => 'Passionate about engineering clean architectures and meaningful user experiences',
                        'description' => 'Enku Taddesse is a Software Engineer and Full Stack Developer based at Dire Dawa University. She has contributed as an intern project manager at Teter Trending PLC leading client builds such as the Akilil Digital Realm website, and actively leads core initiatives at DDU ICT Club and ABOL Solution.',
                        'image_shape' => 'squircle',
                        'points' => [
                            [
                                'title' => 'Teter Trending PLC (2026)',
                                'description' => 'Intern Project Manager managing direct client requirements, milestones, and deployment for Akilil Digital Realm.',
                            ],
                            [
                                'title' => 'DDU ICT Club Core Lead',
                                'description' => 'Organizing campus hackathons, student coding workshops, and collaborative open-source tooling.',
                            ],
                            [
                                'title' => 'LegnaPath & Platform Engineering',
                                'description' => 'Architected mentorship matching, micro-service features, and responsive dashboard workflows.',
                            ],
                        ],
                    ],
                    'stats' => [
                        'is_visible' => true,
                        'eyebrow' => 'Impact & Experience',
                        'title' => 'Key milestones and community track record',
                        'items' => [
                            [
                                'number' => '12+',
                                'label' => 'Software Projects Built',
                                'description' => 'Web platforms, plugins, ordering systems, and localized tooling.',
                            ],
                            [
                                'number' => '3+',
                                'label' => 'Organizations & Clubs',
                                'description' => 'Teter Trending PLC, DDU ICT Club, and ABOL Solution.',
                            ],
                            [
                                'number' => '100%',
                                'label' => 'Modern Web Stack',
                                'description' => 'Laravel, PHP, JavaScript, Bootstrap/Tailwind, and MySQL.',
                            ],
                            [
                                'number' => '24-48h',
                                'label' => 'Fast Response Time',
                                'description' => 'Quick turnaround on project inquiries and tech collaborations.',
                            ],
                        ],
                    ],
                    'services' => [
                        'is_visible' => false, // Hidden since user requested not to show unnecessary services for individual software engineers
                    ],
                    'portfolio' => [
                        'is_visible' => true,
                        'eyebrow' => 'Selected Work',
                        'title' => 'Featured Engineering Projects',
                        'description' => 'A showcase of web applications, client solutions, and tools engineered for performance and reliability.',
                        'image_shape' => 'squircle',
                    ],
                    'team' => [
                        'is_visible' => true,
                        'eyebrow' => 'Software Engineer',
                        'title' => 'About Enku Taddesse',
                        'description' => 'Full Stack Developer & Intern Project Manager dedicated to building impactful digital solutions.',
                        'cta_text' => 'Download Resume / Contact',
                        'cta_url' => '/contact',
                        'image_shape' => 'squircle',
                    ],
                    'clients' => [
                        'is_visible' => true,
                        'eyebrow' => 'Affiliations & Organizations',
                        'title' => 'Organizations & Partners',
                        'description' => 'Proudly collaborating with forward-thinking tech companies and university academic clubs.',
                    ],
                    'cta' => [
                        'is_visible' => true,
                        'eyebrow' => 'Let’s Build Together',
                        'title' => 'Have a project in mind or want to collaborate?',
                        'description' => 'Reach out via Telegram, email, or schedule a conversation to discuss your next software initiative.',
                        'button_text' => 'Send a Message',
                        'button_url' => '/contact',
                        'secondary_button_text' => 'GitHub Profile',
                        'secondary_button_url' => 'https://github.com/Enqutk',
                    ],
                    'creator' => [
                        'is_visible' => true,
                        'label' => 'Creator of this platform',
                        'name' => 'Kimem Cards',
                        'line' => 'NFC smart cards and live digital profiles.',
                        'cta_text' => 'Visit Kimem',
                        'url' => '/',
                    ],
                ],
            ],
        ];

        // 1. Create or Update Organization
        $org = Organization::updateOrCreate(['slug' => 'enku-taddesse'], $orgData);

        // Also update alias 'enku-tadesse' if accessed
        Organization::where('slug', 'enku-tadesse')->delete();

        // 2. Contacts
        OrganizationContact::where('organization_id', $org->id)->delete();
        foreach ([
            ['type' => 'email', 'value' => 'enkukokob@gmail.com'],
            ['type' => 'phone', 'value' => '+251 931 727 965'],
        ] as $c) {
            OrganizationContact::create([
                'organization_id' => $org->id,
                'type' => $c['type'],
                'value' => $c['value'],
                'status' => StatusEnum::active,
            ]);
        }

        // 3. Social Media
        SocialRef::where('organization_id', $org->id)->delete();
        foreach ([
            ['title' => 'GitHub', 'icon_class' => 'bi bi-github', 'link' => 'https://github.com/Enqutk'],
            ['title' => 'Telegram', 'icon_class' => 'bi bi-telegram', 'link' => 'https://t.me/your_channel'],
            ['title' => 'Email', 'icon_class' => 'bi bi-envelope', 'link' => 'mailto:enkukokob@gmail.com'],
            ['title' => 'Portfolio Bio', 'icon_class' => 'bi bi-globe', 'link' => 'https://enkutadesse.bio'],
        ] as $s) {
            SocialRef::create([
                'organization_id' => $org->id,
                'title' => $s['title'],
                'icon_class' => $s['icon_class'],
                'link' => $s['link'],
                'status' => StatusEnum::active,
            ]);
        }

        // 4. Team Profile (Single profile representing Enku)
        Team::where('organization_id', $org->id)->delete();
        Team::create([
            'organization_id' => $org->id,
            'first_name' => 'Enku',
            'last_name' => 'Taddesse',
            'title' => 'Software Engineer & Full Stack Developer',
            'description' => 'Dire Dawa University software engineer with experience as intern project manager at Teter Trending PLC and core lead at DDU ICT Club.',
            'founder' => true,
            'order' => 1,
            'status' => StatusEnum::active,
        ]);

        // 5. Featured Projects (Entities)
        Entity::where('organization_id', $org->id)->delete();
        $projects = [
            [
                'name' => 'Akilil Digital Realm Website',
                'type' => EntityTypeEnum::project,
                'category' => 'Web Development',
                'link' => 'https://enkutadesse.bio',
                'description' => 'Intern project manager with direct client contact, coordinating feature delivery, UI alignment, and production deployment (2026).',
                'order' => 1,
            ],
            [
                'name' => 'LegnaPath Mentorship Platform',
                'type' => EntityTypeEnum::project,
                'category' => 'Full Stack Platform',
                'link' => 'https://github.com/Enqutk',
                'description' => 'Engineered student mentorship features, matchmaking algorithms, and secure workflow dashboards (2025).',
                'order' => 2,
            ],
            [
                'name' => 'Custom User Form Plugin',
                'type' => EntityTypeEnum::project,
                'category' => 'CMS Plugin',
                'link' => 'https://github.com/Enqutk',
                'description' => 'Shortcode-based data capture and dynamic form management plugin with backend submission controls.',
                'order' => 3,
            ],
            [
                'name' => 'Food Ordering System',
                'type' => EntityTypeEnum::project,
                'category' => 'Web Application',
                'link' => 'https://github.com/Enqutk/shopping',
                'description' => 'Ordering web application with seamless guest checkout, item catalog filtering, and cart state persistence.',
                'order' => 4,
            ],
            [
                'name' => 'Freelance Dire',
                'type' => EntityTypeEnum::project,
                'category' => 'Community Platform',
                'link' => 'https://github.com/Enqutk/jeffery-job',
                'description' => 'Localized student hiring platform connecting skilled university developers with local business projects.',
                'order' => 5,
            ],
            [
                'name' => 'Memory Maze & Keyboard Crush Pro',
                'type' => EntityTypeEnum::project,
                'category' => 'Interactive Tool',
                'link' => 'https://github.com/Enqutk/Keyboard-crush-pro',
                'description' => 'Interactive typing speed test platform and memory-based recall learning web applications.',
                'order' => 6,
            ],
        ];
        foreach ($projects as $p) {
            Entity::create(array_merge($p, [
                'organization_id' => $org->id,
                'status' => StatusEnum::active,
            ]));
        }

        // 6. Affiliations & Partners (Entities)
        $affiliations = [
            [
                'name' => 'Dire Dawa University',
                'type' => EntityTypeEnum::partner,
                'description' => 'Academic & Software Engineering Campus',
                'order' => 1,
            ],
            [
                'name' => 'Teter Trending PLC',
                'type' => EntityTypeEnum::partner,
                'description' => 'Technology & Digital Solutions Agency',
                'order' => 2,
            ],
            [
                'name' => 'DDU ICT Club',
                'type' => EntityTypeEnum::client,
                'description' => 'Student Technology & Innovation Hub',
                'order' => 3,
            ],
            [
                'name' => 'ABOL Solution',
                'type' => EntityTypeEnum::client,
                'description' => 'Digital Products & Systems Development',
                'order' => 4,
            ],
        ];
        foreach ($affiliations as $a) {
            Entity::create(array_merge($a, [
                'organization_id' => $org->id,
                'status' => StatusEnum::active,
            ]));
        }

        // 7. Hero Slides
        Hero::where('organization_id', $org->id)->delete();
        Hero::create([
            'organization_id' => $org->id,
            'subtitle' => 'Full Stack Developer · Dire Dawa University',
            'title' => 'Building clean, robust tools that solve real problems',
            'description' => 'Software Engineer at Dire Dawa University with experience leading project delivery at Teter Trending PLC and coordinating core ICT initiatives.',
            'text_link' => 'Explore Projects',
            'button_link' => '/portfolio',
            'order' => 1,
            'status' => StatusEnum::active,
        ]);
        Hero::create([
            'organization_id' => $org->id,
            'subtitle' => 'Teter Trending PLC & DDU ICT Club',
            'title' => 'Crafting scalable web applications and community software',
            'description' => 'From project management on enterprise client websites to building high-utility platforms like LegnaPath and Freelance Dire.',
            'text_link' => 'Get in Touch',
            'button_link' => '/contact',
            'order' => 2,
            'status' => StatusEnum::active,
        ]);
    }
}
