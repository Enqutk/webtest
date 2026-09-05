<?php

namespace Database\Seeders;

use App\Enums\EntityTypeEnum;
use App\Enums\MenuLocationEnum;
use App\Enums\StatusEnum;
use App\Models\Entity;
use App\Models\Hero;
use App\Models\MenuItem;
use App\Models\MenuLocation;
use App\Models\Organization;
use App\Models\OrganizationContact;
use App\Models\Service;
use App\Models\SocialRef;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class YeabsiraEndaleSeeder extends Seeder
{
    public function run(): void
    {
        $orgData = [
            'title' => 'Yeabsira Endale Kukusha',
            'slug' => 'yeabsira-endale',
            'tagline' => 'Software Engineer · Junior PM · Creator of Kimem Cards',
            'meta_description' => 'Yeabsira Endale Kukusha — creator of Kimem Cards. Software engineer and junior project manager building Laravel, Flutter, and NFC digital-profile platforms.',
            'po_box' => 'Dire Dawa University',
            'address' => 'Addis Ababa · Dire Dawa, Ethiopia',
            'opening_hours' => [
                [
                    'days' => ['mon', 'tue', 'wed', 'thu', 'fri'],
                    'from' => '09:00:00',
                    'to' => '18:00:00',
                ],
            ],
            'status' => 'active',
            'theme' => [
                'bg' => '#f6f3ee',
                'surface' => '#fffefb',
                'ink' => '#1b2430',
                'muted' => '#5c6570',
                'line' => '#e4ded6',
                'accent' => '#1d4e4a',
                'accent_dark' => '#143c39',
                'accent_soft' => 'rgba(29, 78, 74, 0.10)',
                'dark' => '#1b2430',
                'font_display' => 'Fraunces',
                'font_body' => 'Outfit',
                'brand_font_family' => 'Fraunces',
                'brand_font_weight' => '700',
                'brand_letter_spacing' => '-0.03em',
                'tagline_font_family' => 'Outfit',
                'tagline_font_style' => 'normal',
                'tagline_font_weight' => '500',
                'nav_font_family' => 'Outfit',
                'nav_font_weight' => '500',
                'nav_spacing' => '0.55rem 0.95rem',
                'image_shape' => 'rounded-xl',
                'show_logo' => false,
                'show_brand_text' => true,
                'show_tagline' => true,
                'show_header_cta' => true,
                'header_cta_text' => 'Say hello',
                'show_address' => true,
                'show_po_box' => true,
                'show_opening_hours' => false,
                'show_email' => true,
                'show_phone' => true,
                'show_social_links' => true,
                'show_footer_credit' => true,
                'footer_credit_text' => 'Yeabsira Endale Kukusha',
                'footer_credit_url' => '/',
                'footer_credit_html' => 'Creator of <a href="/">Kimem Cards</a> — this platform.',
                'creator' => [
                    'is_visible' => true,
                    'label' => 'Creator of this platform',
                    'name' => 'Kimem Cards',
                    'line' => 'NFC smart cards and live digital profiles. You are on a site I built.',
                    'cta_text' => 'Visit Kimem',
                    'url' => '/',
                ],
                'nav_items' => [
                    ['label' => 'Home', 'url' => '/', 'is_visible' => true, 'target' => '_self', 'show_in_footer' => true],
                    ['label' => 'Me', 'url' => '/about', 'is_visible' => true, 'target' => '_self', 'show_in_footer' => true],
                    ['label' => 'Gallery', 'url' => '/our-services', 'is_visible' => true, 'target' => '_self', 'show_in_footer' => true],
                    ['label' => 'Work', 'url' => '/portfolio', 'is_visible' => true, 'target' => '_self', 'show_in_footer' => true],
                    ['label' => 'Contact', 'url' => '/contact', 'is_visible' => true, 'target' => '_self', 'show_in_footer' => true],
                ],
                'home_sections' => [
                    'hero' => [
                        'is_visible' => true,
                        'badge' => 'Creator of Kimem Cards · Software Engineer · Junior PM',
                        'subtitle' => 'Backend Engineering & Delivery Leadership',
                        'title' => 'I built the platform you are standing on',
                        'description' => 'Creator of Kimem Cards — NFC smart cards and multi-tenant digital profiles. I also ship Laravel backends at TETER Trading and keep delivery moving as a junior project manager.',
                        'cta_text' => 'View Work',
                        'cta_url' => '/portfolio',
                        'secondary_cta_text' => 'Meet me',
                        'secondary_cta_url' => '/about',
                        'image_shape' => 'rounded-xl',
                        'slides' => [
                            [
                                'eyebrow' => 'Creator of Kimem Cards',
                                'title' => 'This NFC card platform — live profiles, theming, tap-to-share — is mine',
                                'description' => 'I designed and engineered Kimem: multi-tenant Laravel sites, NFC digital cards, and the profile you are reading right now.',
                                'button_label' => 'See the work',
                                'button_url' => '/portfolio',
                                'image_shape' => 'rounded-xl',
                                'is_visible' => true,
                            ],
                            [
                                'eyebrow' => 'Software Engineer & Junior PM',
                                'title' => 'Laravel backends, milestones, and products that actually launch',
                                'description' => 'Engineering at TETER Trading plus junior project management: scoped work, honest dates, and shipped features.',
                                'button_label' => 'Open gallery',
                                'button_url' => '/our-services',
                                'image_shape' => 'rounded-xl',
                                'is_visible' => true,
                            ],
                        ],
                    ],
                    'about' => [
                        'is_visible' => true,
                        'layout' => 'me',
                        'eyebrow' => 'Me',
                        'kicker' => 'Creator',
                        'portrait_role' => 'Creator of Kimem Cards',
                        'title' => 'I write the code, keep the project moving, and I built Kimem',
                        'description' => 'I’m Yeabsira — creator of Kimem Cards, software engineer, and junior project manager. This NFC smart-card platform is mine. I also ship Laravel backends at TETER Trading, lead builders at DDU ICT Club, and study Computer Software Engineering at Dire Dawa University (GPA 3.97).',
                        'cta_text' => 'More about me',
                        'cta_url' => '/about',
                        'image_shape' => 'rounded-xl',
                        'points' => [
                            [
                                'title' => 'Creator of Kimem Cards',
                                'description' => 'I built this platform: NFC cards, multi-tenant profiles, theming, and the site you are on.',
                            ],
                            [
                                'title' => 'TETER Trading — Backend & Junior PM (2025–present)',
                                'description' => 'Laravel, Spatie, and Flutter delivery: APIs, CMS, auth, and client-facing project coordination.',
                            ],
                            [
                                'title' => 'DDU ICT Club Leader',
                                'description' => 'Public relations, workshops, and campus engineering community — turning students into builders.',
                            ],
                            [
                                'title' => 'Education & dual track',
                                'description' => 'B.E. Computer Software Engineering at Dire Dawa University (GPA 3.97) and Management at Haramaya University.',
                            ],
                        ],
                    ],
                    'stats' => [
                        'is_visible' => true,
                        'variant' => 'light',
                        'eyebrow' => 'At a glance',
                        'title' => 'A light snapshot of how I work',
                        'items' => [
                            [
                                'value' => '3.97',
                                'number' => '3.97',
                                'label' => 'GPA · Software Engineering',
                                'description' => 'B.E. Computer Software Engineering, Dire Dawa University.',
                            ],
                            [
                                'value' => '3+',
                                'number' => '3+',
                                'label' => 'Years Building Software',
                                'description' => 'Backend web, freelance delivery, and campus tech leadership.',
                            ],
                            [
                                'value' => '1st',
                                'number' => '1st',
                                'label' => 'Cursor Hackathon · Addis Ababa',
                                'description' => 'Winning team on KnoQ, an AI-assisted EdTech product.',
                            ],
                            [
                                'value' => '1',
                                'number' => '1',
                                'label' => 'Platform I created',
                                'description' => 'Kimem Cards — NFC smart cards and the digital profiles running this site.',
                            ],
                        ],
                    ],
                    'services' => [
                        'is_visible' => true,
                        'layout' => 'gallery',
                        'eyebrow' => 'Gallery',
                        'title' => 'A studio of how I work',
                        'description' => 'Not a service menu — a gallery of the crafts I actually practice.',
                        'cta_text' => 'Full gallery',
                        'cta_url' => '/our-services',
                    ],
                    'portfolio' => [
                        'is_visible' => true,
                        'eyebrow' => 'Selected Work',
                        'title' => 'Projects that show both code and delivery',
                        'description' => 'A CV-style showcase of platforms, client systems, community software, and hackathon work.',
                        'image_shape' => 'rounded-xl',
                        'cta_text' => 'Full portfolio',
                        'cta_url' => '/portfolio',
                    ],
                    'team' => [
                        'is_visible' => false,
                        'eyebrow' => 'The Profile',
                        'title' => 'Yeabsira Endale Kukusha',
                        'description' => 'Software Engineer & Junior Project Manager — available for engineering roles, internships, and product delivery collaborations.',
                        'cta_text' => 'Get in Touch',
                        'cta_url' => '/contact',
                        'image_shape' => 'rounded-xl',
                    ],
                    'clients' => [
                        'is_visible' => true,
                        'eyebrow' => 'Affiliations',
                        'title' => 'Teams, campus, and partners',
                        'description' => 'Companies, clubs, and universities that shape the work on this resume.',
                    ],
                    'cta' => [
                        'is_visible' => true,
                        'eyebrow' => 'Open to Opportunities',
                        'title' => 'Need an engineer who can also keep delivery on track?',
                        'description' => 'Reach out for software engineering roles, junior PM collaborations, freelance builds, or campus-to-industry projects.',
                        'button_text' => 'Send a Message',
                        'button_url' => '/contact',
                        'secondary_button_text' => 'LinkedIn',
                        'secondary_button_url' => 'https://www.linkedin.com/in/engkukusha',
                    ],
                    'creator' => [
                        'is_visible' => true,
                        'label' => 'Creator of this platform',
                        'name' => 'Kimem Cards',
                        'line' => 'NFC smart cards and live digital profiles. You are on a site I built.',
                        'cta_text' => 'Visit Kimem',
                        'url' => '/',
                    ],
                ],
                'pages' => [
                    'about' => [
                        'layout' => 'me',
                        'eyebrow' => 'Me',
                        'title' => 'Me',
                        'description' => 'Creator of Kimem Cards — a first-person look at how I engineer, coordinate, and ship a live platform.',
                        'intro' => [
                            'eyebrow' => 'Me',
                            'kicker' => 'Creator',
                            'portrait_role' => 'Creator of Kimem Cards',
                            'title' => 'Hello — I’m Yeabsira.',
                            'description' => 'I am the creator of Kimem Cards. I design Laravel backends, then stay close to the timeline so the work actually launches. Software engineering plus junior project management is how I spend the week — and this platform is the proof.',
                            'image' => null,
                            'points' => [
                                [
                                    'title' => 'The creator in me',
                                    'icon' => 'bi bi-upc-scan',
                                    'description' => 'Kimem Cards: NFC smart cards, multi-tenant profiles, and the live site you are reading.',
                                ],
                                [
                                    'title' => 'The engineer in me',
                                    'icon' => 'bi bi-code-slash',
                                    'description' => 'Laravel, Spatie, REST APIs, auth, CMS dashboards, and production debugging.',
                                ],
                                [
                                    'title' => 'The project manager in me',
                                    'icon' => 'bi bi-kanban',
                                    'description' => 'Requirements, milestones, stakeholder updates, and cut-lines that protect quality.',
                                ],
                                [
                                    'title' => 'The community in me',
                                    'icon' => 'bi bi-people',
                                    'description' => 'DDU ICT Club leadership, workshops, and helping campus builders ship.',
                                ],
                            ],
                        ],
                        'story' => [
                            'eyebrow' => 'Two sides of me',
                            'title' => 'How I got here',
                            'panels' => [
                                [
                                    'title' => 'The engineer',
                                    'description' => 'I created Kimem Cards — the NFC smart-card and digital-profile platform this page runs on. Backend web developer at TETER Trading since 2025, with freelance Laravel/Flutter work. Stack: Laravel, Spatie, APIs, multi-tenant theming.',
                                    'image' => null,
                                ],
                                [
                                    'title' => 'The coordinator',
                                    'description' => 'Junior project manager habits: client communication, scoped milestones, and honest dates. Management studies at Haramaya, leadership at DDU ICT Club, and first place at Cursor’s Addis Ababa hackathon with KnoQ.',
                                    'image' => null,
                                ],
                            ],
                        ],
                        'show_stats' => true,
                        'show_team' => false,
                        'show_clients' => true,
                        'show_cta' => true,
                    ],
                    'contact' => [
                        'eyebrow' => 'Let’s work',
                        'title' => 'Say hello',
                        'description' => 'Open to software engineering roles, junior PM collaborations, and product builds.',
                        'intro' => 'Send a short brief — role, product, or project — and I will reply with next steps. LinkedIn and GitHub are the fastest professional channels besides email.',
                    ],
                    'services' => [
                        'layout' => 'gallery',
                        'eyebrow' => 'Gallery',
                        'title' => 'Gallery',
                        'description' => 'A studio wall of crafts I practice — not a generic services list.',
                        'icons' => [
                            'yeabsira-kimem-creator' => 'bi bi-upc-scan',
                            'yeabsira-backend-engineering' => 'bi bi-braces',
                            'yeabsira-junior-project-management' => 'bi bi-kanban',
                            'yeabsira-flutter-product-ui' => 'bi bi-phone',
                            'yeabsira-web-delivery' => 'bi bi-globe2',
                            'yeabsira-community-leadership' => 'bi bi-people',
                            'yeabsira-rapid-builds' => 'bi bi-lightning-charge',
                        ],
                    ],
                    'portfolio' => [
                        'eyebrow' => 'Selected work',
                        'title' => 'Projects & delivery',
                        'description' => 'Platforms, client systems, community software, and hackathon work that belong on a software-engineer CV.',
                    ],
                ],
            ],
        ];

        $org = Organization::updateOrCreate(['slug' => 'yeabsira-endale'], $orgData);

        $admin = User::query()->where('email', 'admin@admin.com')->first() ?? User::query()->first();
        if ($admin) {
            $org->users()->syncWithoutDetaching([
                $admin->id => ['role' => 'owner'],
            ]);
        }

        OrganizationContact::where('organization_id', $org->id)->delete();
        foreach ([
            ['type' => 'email', 'value' => 'yeabsira0514@gmail.com'],
        ] as $c) {
            OrganizationContact::create([
                'organization_id' => $org->id,
                'type' => $c['type'],
                'value' => $c['value'],
                'status' => StatusEnum::active,
            ]);
        }

        SocialRef::where('organization_id', $org->id)->delete();
        foreach ([
            ['title' => 'LinkedIn', 'icon_class' => 'bi bi-linkedin', 'link' => 'https://www.linkedin.com/in/engkukusha', 'order' => 1],
            ['title' => 'GitHub', 'icon_class' => 'bi bi-github', 'link' => 'https://github.com/Itsyabitaa', 'order' => 2],
            ['title' => 'X', 'icon_class' => 'bi bi-twitter-x', 'link' => 'https://x.com/kukusha0514', 'order' => 3],
            ['title' => 'Instagram', 'icon_class' => 'bi bi-instagram', 'link' => 'https://instagram.com/kukusha0512', 'order' => 4],
            ['title' => 'Email', 'icon_class' => 'bi bi-envelope', 'link' => 'mailto:yeabsira0514@gmail.com', 'order' => 5],
        ] as $s) {
            SocialRef::create([
                'organization_id' => $org->id,
                'title' => $s['title'],
                'icon_class' => $s['icon_class'],
                'link' => $s['link'],
                'order' => $s['order'],
                'status' => StatusEnum::active,
            ]);
        }

        Team::where('organization_id', $org->id)->delete();
        Team::create([
            'organization_id' => $org->id,
            'first_name' => 'Yeabsira',
            'last_name' => 'Endale Kukusha',
            'title' => 'Software Engineer, Junior Project Manager & Creator of Kimem Cards',
            'description' => 'I built Kimem Cards — this NFC smart-card platform. I also ship Laravel products at TETER Trading and keep delivery moving.',
            'founder' => true,
            'order' => 1,
            'status' => StatusEnum::active,
        ]);

        $services = [
            [
                'title' => 'Creator of Kimem Cards',
                'slug' => 'yeabsira-kimem-creator',
                'short_description' => 'I built this platform: NFC smart cards, multi-tenant digital profiles, theming, and tap-to-share.',
                'description' => 'Kimem Cards is my product. I engineered the multi-tenant Laravel engine behind NFC business cards and live personal sites — including the profile you are on. Branding, portfolio, contact, and gallery all sit on architecture I designed and shipped.',
                'features' => '<ul><li>Multi-tenant digital profiles</li><li>NFC smart-card tap-to-share</li><li>Custom themes, type, and layout per card</li><li>Portfolio, gallery, and contact flows</li><li>Admin studio for live editing</li></ul>',
                'quote' => 'If you are reading this card, you are already inside the platform I created.',
                'order' => 1,
            ],
            [
                'title' => 'Backend Software Engineering',
                'slug' => 'yeabsira-backend-engineering',
                'short_description' => 'Laravel APIs, Spatie auth/media, CMS dashboards, and production-ready backend features.',
                'description' => 'I design and implement backend systems that other developers can extend: clear models, role-based access, media, and REST endpoints. Daily work includes Laravel, debugging production mismatches, and keeping the data layer honest.',
                'features' => '<ul><li>Laravel application architecture</li><li>REST APIs and authentication</li><li>Spatie permissions, media, and CMS patterns</li><li>MySQL modeling and migrations</li><li>Production debugging and deploy hygiene</li></ul>',
                'quote' => 'Readable code is a delivery tool — not a luxury.',
                'order' => 2,
            ],
            [
                'title' => 'Junior Project Management',
                'slug' => 'yeabsira-junior-project-management',
                'short_description' => 'Requirements, milestones, client updates, and cutting scope so the important work ships.',
                'description' => 'Alongside engineering, I coordinate delivery: capture what the client actually needs, break it into milestones, and keep engineering and stakeholders aligned. Management studies at Haramaya University sit next to the software degree for a reason.',
                'features' => '<ul><li>Client requirement gathering</li><li>Milestone planning and follow-up</li><li>Scope trade-offs that protect quality</li><li>Status communication in plain language</li><li>Handover notes teams can run with</li></ul>',
                'quote' => 'A feature is not done until someone can use it.',
                'order' => 3,
            ],
            [
                'title' => 'Flutter & Product UI',
                'slug' => 'yeabsira-flutter-product-ui',
                'short_description' => 'Mobile and web interfaces that make backend work usable for real people.',
                'description' => 'Flutter and modern web UI so APIs become products. Comfortable pairing backend contracts with screens, empty states, and admin tools that non-engineers can operate.',
                'features' => '<ul><li>Flutter screens wired to APIs</li><li>Admin and CMS interfaces</li><li>Responsive web layouts</li><li>Handoff between design and backend</li></ul>',
                'quote' => 'The interface is how the architecture proves itself.',
                'order' => 4,
            ],
            [
                'title' => 'End-to-End Web Delivery',
                'slug' => 'yeabsira-web-delivery',
                'short_description' => 'Freelance and in-house builds from first brief through deploy and small-team support.',
                'description' => 'Freelance web development plus in-house delivery at TETER: take a brief, propose a stack, ship a first version, and stay available for the messy last 10%. Includes multi-tenant sites such as Kimem digital cards.',
                'features' => '<ul><li>Brief to first production version</li><li>Multi-tenant Laravel sites</li><li>Content and branding customization</li><li>Post-launch fixes and iteration</li></ul>',
                'quote' => 'Ship a version people can react to — then improve it.',
                'order' => 5,
            ],
            [
                'title' => 'Community Leadership',
                'slug' => 'yeabsira-community-leadership',
                'short_description' => 'DDU ICT Club: workshops, public relations, and helping students ship real work.',
                'description' => 'Club leadership is part of the CV, not a side note. I organize, communicate, and keep campus builders moving from idea to demo.',
                'features' => '<ul><li>Workshop design and facilitation</li><li>Public relations for a student tech club</li><li>Mentoring junior builders</li><li>Community software that leaves the classroom</li></ul>',
                'quote' => 'Community is a delivery system for talent.',
                'order' => 6,
            ],
            [
                'title' => 'Rapid Builds & Hackathons',
                'slug' => 'yeabsira-rapid-builds',
                'short_description' => 'Tight clocks, clear cuts, and a first-place finish at Cursor Addis Ababa.',
                'description' => 'Hackathon pace is project management under pressure. KnoQ at Cursor’s first Addis Ababa hackathon is the proof: pick a slice, ship it, tell the story.',
                'features' => '<ul><li>Scoped slices under a deadline</li><li>Cross-functional pairing</li><li>Demo-ready storytelling</li><li>AI-assisted product sketches</li></ul>',
                'quote' => 'A tight clock is a design constraint — treat it that way.',
                'order' => 7,
            ],
        ];

        Service::where('organization_id', $org->id)->forceDelete();
        foreach ($services as $s) {
            Service::withTrashed()->updateOrCreate(
                ['slug' => $s['slug']],
                array_merge($s, [
                    'organization_id' => $org->id,
                    'status' => StatusEnum::active,
                    'deleted_at' => null,
                ])
            );
        }

        Entity::where('organization_id', $org->id)->delete();
        $projects = [
            [
                'name' => 'Kimem Cards — Platform I created',
                'type' => EntityTypeEnum::project,
                'category' => 'Creator · Full Stack',
                'link' => '/',
                'description' => 'I am the creator of Kimem Cards. NFC smart cards, multi-tenant Laravel profiles, live theming, and this CV site all run on architecture I designed and shipped.',
                'order' => 1,
            ],
            [
                'name' => 'TETER Trading — CMS & Client Delivery',
                'type' => EntityTypeEnum::project,
                'category' => 'Backend · Project Coordination',
                'link' => 'https://www.linkedin.com/company/tetertrading',
                'description' => 'Backend web development and junior PM work: REST APIs, CMS dashboards, roles, and coordinating client feature delivery at TETER Trading (2025–present).',
                'order' => 2,
            ],
            [
                'name' => 'KnoQ — Cursor Hackathon, Addis Ababa',
                'type' => EntityTypeEnum::project,
                'category' => 'EdTech · Hackathon',
                'link' => 'https://www.linkedin.com/in/engkukusha',
                'description' => 'First-place team at Cursor’s first Addis Ababa hackathon. AI-assisted EdTech product work under a tight clock with a cross-functional squad.',
                'order' => 3,
            ],
            [
                'name' => 'Freelance Laravel & Flutter Builds',
                'type' => EntityTypeEnum::project,
                'category' => 'Freelance',
                'link' => 'https://github.com/Itsyabitaa',
                'description' => 'Independent web and mobile delivery: scoped briefs, Laravel backends, and Flutter clients for small teams that need a first production version.',
                'order' => 4,
            ],
            [
                'name' => 'DDU ICT Club Platforms & Workshops',
                'type' => EntityTypeEnum::project,
                'category' => 'Community Leadership',
                'link' => 'https://www.linkedin.com/company/ddu-ict-club',
                'description' => 'Club leadership and PR: student workshops, community software, and helping campus builders ship work beyond the classroom.',
                'order' => 5,
            ],
            [
                'name' => 'CodSoft Web Development Internship',
                'type' => EntityTypeEnum::project,
                'category' => 'Internship',
                'link' => 'https://www.linkedin.com/in/engkukusha',
                'description' => 'Structured web-development internship focused on shipping assigned features, learning delivery cadence, and strengthening frontend/backend fundamentals.',
                'order' => 6,
            ],
        ];
        foreach ($projects as $p) {
            Entity::create(array_merge($p, [
                'organization_id' => $org->id,
                'status' => StatusEnum::active,
            ]));
        }

        $affiliations = [
            [
                'name' => 'Kimem Cards',
                'type' => EntityTypeEnum::partner,
                'description' => 'Founder & platform creator',
                'order' => 1,
            ],
            [
                'name' => 'TETER Trading',
                'type' => EntityTypeEnum::partner,
                'description' => 'Backend web developer & junior project coordination',
                'order' => 2,
            ],
            [
                'name' => 'Dire Dawa University',
                'type' => EntityTypeEnum::partner,
                'description' => 'B.E. Computer Software Engineering · GPA 3.97',
                'order' => 3,
            ],
            [
                'name' => 'DDU ICT Club',
                'type' => EntityTypeEnum::client,
                'description' => 'Club leadership · public relations · student builders',
                'order' => 4,
            ],
            [
                'name' => 'Haramaya University',
                'type' => EntityTypeEnum::partner,
                'description' => 'Bachelor track in Management',
                'order' => 5,
            ],
        ];
        foreach ($affiliations as $a) {
            Entity::create(array_merge($a, [
                'organization_id' => $org->id,
                'status' => StatusEnum::active,
            ]));
        }

        Hero::where('organization_id', $org->id)->delete();
        Hero::create([
            'organization_id' => $org->id,
            'subtitle' => 'Creator of Kimem Cards',
            'title' => 'I built the platform you are standing on',
            'description' => 'NFC smart cards, multi-tenant digital profiles, and this live CV — designed and engineered by me.',
            'text_link' => 'See the work',
            'button_link' => '/portfolio',
            'order' => 1,
            'status' => StatusEnum::active,
        ]);
        Hero::create([
            'organization_id' => $org->id,
            'subtitle' => 'Software Engineer · Junior Project Manager',
            'title' => 'Laravel backends, milestones, and products that actually launch',
            'description' => 'Engineering at TETER Trading plus junior project management: scoped work, honest dates, and shipped features.',
            'text_link' => 'Meet me',
            'button_link' => '/about',
            'order' => 2,
            'status' => StatusEnum::active,
        ]);

        $menu = MenuLocation::updateOrCreate(
            [
                'organization_id' => $org->id,
                'location' => MenuLocationEnum::Navbar,
            ],
            [
                'name' => 'Yeabsira CV Navigation',
                'slug' => 'yeabsira-endale-nav',
                'description' => 'Resume-style navigation for the personal CV card',
            ]
        );

        MenuItem::where('menu_id', $menu->id)->forceDelete();
        foreach ([
            ['title' => 'Home', 'url' => '/', 'order_number' => 1],
            ['title' => 'Me', 'url' => '/about', 'order_number' => 2],
            ['title' => 'Gallery', 'url' => '/our-services', 'order_number' => 3],
            ['title' => 'Work', 'url' => '/portfolio', 'order_number' => 4],
            ['title' => 'Contact', 'url' => '/contact', 'order_number' => 5],
        ] as $item) {
            MenuItem::create([
                'menu_id' => $menu->id,
                'parent_id' => null,
                'title' => $item['title'],
                'link_type' => 'internal',
                'url' => $item['url'],
                'target' => '_self',
                'order_number' => $item['order_number'],
                'show_in_footer' => true,
            ]);
        }
    }
}
