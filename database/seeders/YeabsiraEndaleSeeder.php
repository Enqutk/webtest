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
            'tagline' => 'Software Engineer · Junior Project Manager · Creator of Kimem Cards',
            'meta_description' => 'Yeabsira Endale Kukusha — software engineer and junior project manager in Addis Ababa and Dire Dawa. Creator of Kimem Cards. Laravel backends, product delivery, and a 3.97 GPA in Computer Software Engineering.',
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
                'bg' => '#f3f8fd',
                'surface' => '#ffffff',
                'ink' => '#102033',
                'muted' => '#526274',
                'line' => '#d5e3f0',
                'accent' => '#0b74d1',
                'accent_dark' => '#08569b',
                'accent_soft' => 'rgba(11, 116, 209, 0.12)',
                'dark' => '#0c1c30',
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
                'header_cta_text' => 'See the work',
                'header_cta_url' => '/portfolio',
                'section_order' => ['hero', 'portfolio', 'about', 'stats', 'services', 'clients', 'cta'],
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
                    ['label' => 'Work', 'url' => '/portfolio', 'is_visible' => true, 'target' => '_self', 'show_in_footer' => true],
                    ['label' => 'Me', 'url' => '/about', 'is_visible' => true, 'target' => '_self', 'show_in_footer' => true],
                    ['label' => 'Gallery', 'url' => '/our-services', 'is_visible' => true, 'target' => '_self', 'show_in_footer' => true],
                    ['label' => 'Contact', 'url' => '/contact', 'is_visible' => true, 'target' => '_self', 'show_in_footer' => true],
                ],
                'home_sections' => [
                    'hero' => [
                        'is_visible' => true,
                        'badge' => 'Software Engineer · Junior Project Manager · Addis Ababa',
                        'subtitle' => 'Backend engineering and delivery',
                        'title' => 'I build the product, then I stay until it launches',
                        'description' => 'Creator of Kimem Cards. I write Laravel backends at TETER Trading and keep the milestone honest as a junior project manager.',
                        'cta_text' => 'See the work',
                        'cta_url' => '/portfolio',
                        'secondary_cta_text' => 'About me',
                        'secondary_cta_url' => '/about',
                        'image_shape' => 'rounded-xl',
                        'slides' => [
                            [
                                'eyebrow' => 'Portfolio',
                                'title' => 'Platforms, client systems, and a product people can tap',
                                'description' => 'Kimem Cards, delivery at TETER Trading, campus workshops, and a first-place finish at Cursor’s Addis Ababa hackathon.',
                                'button_label' => 'Open the portfolio',
                                'button_url' => '/portfolio',
                                'image_shape' => 'rounded-xl',
                                'is_visible' => true,
                            ],
                            [
                                'eyebrow' => 'How I work',
                                'title' => 'Clear scope, readable code, and a date I can stand behind',
                                'description' => 'Engineering and junior project management in the same week, so the version that ships is the one we agreed to build.',
                                'button_label' => 'Read the story',
                                'button_url' => '/about',
                                'image_shape' => 'rounded-xl',
                                'is_visible' => true,
                            ],
                        ],
                    ],
                    'about' => [
                        'is_visible' => true,
                        'layout' => 'me',
                        'eyebrow' => 'About',
                        'kicker' => 'Engineer',
                        'portrait_role' => 'Software Engineer & Junior PM',
                        'title' => 'Specific work, shipped clean, and easy to hand over',
                        'description' => 'I’m Yeabsira Endale Kukusha. I study Computer Software Engineering at Dire Dawa University, with a 3.97 GPA, and Management at Haramaya University. I created Kimem Cards, build Laravel and Flutter products at TETER Trading, and lead the public side of DDU ICT Club.',
                        'cta_text' => 'More about me',
                        'cta_url' => '/about',
                        'image_shape' => 'rounded-xl',
                        'points' => [
                            [
                                'title' => 'Kimem Cards',
                                'description' => 'The NFC and digital-profile platform this site runs on. Multi-tenant Laravel, live themes, and tap-to-share.',
                            ],
                            [
                                'title' => 'TETER Trading, 2025–present',
                                'description' => 'Backend features, CMS, and auth with Laravel and Spatie, plus client-facing coordination on the same delivery.',
                            ],
                            [
                                'title' => 'DDU ICT Club',
                                'description' => 'Workshops, public relations, and a campus community that treats students as builders.',
                            ],
                            [
                                'title' => 'Two degrees, one practice',
                                'description' => 'Software engineering at Dire Dawa University and management at Haramaya University.',
                            ],
                        ],
                    ],
                    'stats' => [
                        'is_visible' => true,
                        'variant' => 'light',
                        'eyebrow' => 'Record',
                        'title' => 'A short, honest account of the work so far',
                        'items' => [
                            [
                                'value' => '3.97',
                                'number' => '3.97',
                                'label' => 'GPA, Software Engineering',
                                'description' => 'B.E. Computer Software Engineering at Dire Dawa University.',
                            ],
                            [
                                'value' => '3+',
                                'number' => '3+',
                                'label' => 'Years building software',
                                'description' => 'Backend web, freelance delivery, and campus tech leadership.',
                            ],
                            [
                                'value' => '1st',
                                'number' => '1st',
                                'label' => 'Cursor Hackathon, Addis Ababa',
                                'description' => 'Winning team on KnoQ, an AI-assisted EdTech product.',
                            ],
                            [
                                'value' => '1',
                                'number' => '1',
                                'label' => 'Platform I created',
                                'description' => 'Kimem Cards — NFC smart cards and the profiles on this site.',
                            ],
                        ],
                    ],
                    'services' => [
                        'is_visible' => true,
                        'layout' => 'gallery',
                        'eyebrow' => 'Practice',
                        'title' => 'The crafts I actually use',
                        'description' => 'A studio wall of the work I do week to week — product, backend, delivery, and community.',
                        'cta_text' => 'Open the gallery',
                        'cta_url' => '/our-services',
                    ],
                    'portfolio' => [
                        'is_visible' => true,
                        'eyebrow' => 'Portfolio',
                        'title' => 'Work I can walk you through',
                        'description' => 'A product I created, client delivery, community software, and a hackathon win. Each one is something I designed, built, or carried to launch.',
                        'image_shape' => 'rounded-xl',
                        'cta_text' => 'Full portfolio',
                        'cta_url' => '/portfolio',
                    ],
                    'team' => [
                        'is_visible' => false,
                        'eyebrow' => 'Profile',
                        'title' => 'Yeabsira Endale Kukusha',
                        'description' => 'Software engineer and junior project manager, open to engineering roles, internships, and product collaborations.',
                        'cta_text' => 'Get in touch',
                        'cta_url' => '/contact',
                        'image_shape' => 'rounded-xl',
                    ],
                    'clients' => [
                        'is_visible' => true,
                        'eyebrow' => 'Affiliations',
                        'title' => 'Where the work happens',
                        'description' => 'The company, the universities, and the club that shape the projects on this site.',
                    ],
                    'cta' => [
                        'is_visible' => true,
                        'eyebrow' => 'Open to work',
                        'title' => 'Need an engineer who will also keep the date?',
                        'description' => 'Software engineering roles, junior project-management collaborations, freelance builds, and campus-to-industry projects.',
                        'button_text' => 'Send a note',
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
                        'eyebrow' => 'About',
                        'title' => 'About',
                        'description' => 'How I engineer, coordinate, and ship — including the platform this profile runs on.',
                        'intro' => [
                            'eyebrow' => 'About',
                            'kicker' => 'Engineer',
                            'portrait_role' => 'Software Engineer & Junior PM',
                            'title' => 'Hello — I’m Yeabsira.',
                            'description' => 'I created Kimem Cards, then I kept building. Most weeks I am in a Laravel codebase at TETER Trading and in the timeline next to it, so a feature has an owner, a scope, and a date. The management degree sits beside the software degree for that reason.',
                            'image' => null,
                            'points' => [
                                [
                                    'title' => 'The product',
                                    'icon' => 'bi bi-upc-scan',
                                    'description' => 'Kimem Cards: NFC smart cards, multi-tenant profiles, and the live site you are reading.',
                                ],
                                [
                                    'title' => 'The engineering',
                                    'icon' => 'bi bi-code-slash',
                                    'description' => 'Laravel, Spatie, REST APIs, auth, CMS dashboards, and production debugging.',
                                ],
                                [
                                    'title' => 'The delivery',
                                    'icon' => 'bi bi-kanban',
                                    'description' => 'Requirements, milestones, plain-language updates, and a scope that protects the release.',
                                ],
                                [
                                    'title' => 'The community',
                                    'icon' => 'bi bi-people',
                                    'description' => 'DDU ICT Club leadership, workshops, and campus builders who leave with something shipped.',
                                ],
                            ],
                        ],
                        'story' => [
                            'eyebrow' => 'Two sides of the same week',
                            'title' => 'How I got here',
                            'panels' => [
                                [
                                    'title' => 'The engineer',
                                    'description' => 'I created Kimem Cards — the NFC smart-card and digital-profile platform this page runs on. I have been a backend web developer at TETER Trading since 2025, with freelance Laravel and Flutter work alongside it. The daily stack is Laravel, Spatie, APIs, and multi-tenant theming.',
                                    'image' => null,
                                ],
                                [
                                    'title' => 'The coordinator',
                                    'description' => 'Junior project management is the other half: client conversations, scoped milestones, and dates I will still defend on Friday. Management studies at Haramaya, leadership at DDU ICT Club, and first place at Cursor’s Addis Ababa hackathon with KnoQ all sit in that same habit.',
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
                        'eyebrow' => 'Contact',
                        'title' => 'Tell me what you are building',
                        'description' => 'Engineering roles, junior project-management collaborations, and product work.',
                        'intro' => 'A short note is enough — the role, the product, or the date you care about. I will reply with whether I can help and what the next step is. LinkedIn and email are the fastest ways in.',
                    ],
                    'services' => [
                        'layout' => 'gallery',
                        'eyebrow' => 'Practice',
                        'title' => 'Gallery',
                        'description' => 'The crafts behind the portfolio: product, backend, delivery, interface, and community.',
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
                        'eyebrow' => 'Portfolio',
                        'title' => 'Selected work',
                        'description' => 'Six pieces I can explain in detail: the platform I created, client systems, freelance delivery, campus work, and a hackathon that placed first.',
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
            ['type' => 'phone', 'value' => '+251911223344'],
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
            ['title' => 'WhatsApp', 'icon_class' => 'bi bi-whatsapp', 'link' => 'https://wa.me/251911223344', 'order' => 0],
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
            'description' => 'I built Kimem Cards, this NFC and digital-profile platform. At TETER Trading I ship Laravel products and stay with the delivery until someone can use them.',
            'founder' => true,
            'order' => 1,
            'status' => StatusEnum::active,
        ]);

        $services = [
            [
                'title' => 'Creator of Kimem Cards',
                'slug' => 'yeabsira-kimem-creator',
                'short_description' => 'The NFC card and live-profile platform this site runs on, designed and shipped by me.',
                'description' => 'Kimem Cards is my product. A tap opens a profile the owner can keep current: theme, type, portfolio, gallery, and contact, each person on their own site. I engineered the multi-tenant Laravel engine, the public profile, and the studio used after the card is printed.',
                'features' => '<ul><li>Multi-tenant digital profiles</li><li>NFC tap-to-share</li><li>Theme, type, and layout per card</li><li>Portfolio, gallery, and contact</li><li>A studio for editing the live profile</li></ul>',
                'quote' => 'If you are reading this card, you are already inside the platform.',
                'order' => 1,
            ],
            [
                'title' => 'Backend Software Engineering',
                'slug' => 'yeabsira-backend-engineering',
                'short_description' => 'Laravel APIs, Spatie auth and media, CMS dashboards, and backends another developer can extend.',
                'description' => 'I design backend systems with a clear model, role-based access, media, and REST endpoints. The daily work is Laravel, honest data, and the bugs that only appear once a feature is in someone else’s hands.',
                'features' => '<ul><li>Laravel application structure</li><li>REST APIs and authentication</li><li>Spatie permissions, media, and CMS patterns</li><li>MySQL modeling and migrations</li><li>Production debugging and careful deploys</li></ul>',
                'quote' => 'Readable code is how the next person ships on time.',
                'order' => 2,
            ],
            [
                'title' => 'Junior Project Management',
                'slug' => 'yeabsira-junior-project-management',
                'short_description' => 'Requirements, milestones, and a scope small enough for the important work to ship.',
                'description' => 'Beside the code, I coordinate delivery. I write down what the client actually needs, break it into milestones, and keep engineering and stakeholders on the same version of the plan. The management studies at Haramaya sit next to the software degree on purpose.',
                'features' => '<ul><li>Client requirement gathering</li><li>Milestone planning and follow-up</li><li>Scope choices that protect the release</li><li>Status updates in plain language</li><li>Handover notes a team can run with</li></ul>',
                'quote' => 'A feature is finished when someone can use it.',
                'order' => 3,
            ],
            [
                'title' => 'Flutter & Product UI',
                'slug' => 'yeabsira-flutter-product-ui',
                'short_description' => 'Flutter and web screens that make a backend usable for a real person.',
                'description' => 'I pair API contracts with screens, empty states, and admin tools a non-engineer can operate. Flutter when the product is in someone’s hand. Web when the work is a dashboard, a profile, or a public page.',
                'features' => '<ul><li>Flutter screens wired to APIs</li><li>Admin and CMS interfaces</li><li>Responsive web layouts</li><li>A clean handoff between design and backend</li></ul>',
                'quote' => 'The interface is where the architecture proves itself.',
                'order' => 4,
            ],
            [
                'title' => 'End-to-End Web Delivery',
                'slug' => 'yeabsira-web-delivery',
                'short_description' => 'From the first brief to a deployed version, then the small fixes that follow.',
                'description' => 'Freelance web work and in-house delivery at TETER follow the same path: hear the brief, propose a stack, ship a first version, and stay for the last stretch. Kimem’s multi-tenant sites came out of that same practice.',
                'features' => '<ul><li>Brief to a first production version</li><li>Multi-tenant Laravel sites</li><li>Content and branding for each profile</li><li>Fixes and iteration after launch</li></ul>',
                'quote' => 'Ship a version people can react to, then improve it.',
                'order' => 5,
            ],
            [
                'title' => 'Community Leadership',
                'slug' => 'yeabsira-community-leadership',
                'short_description' => 'DDU ICT Club: workshops, public relations, and students who leave with a finished demo.',
                'description' => 'Club leadership is part of the record. I organize, communicate, and keep campus builders moving from an idea to something they can show.',
                'features' => '<ul><li>Workshop design and facilitation</li><li>Public relations for a student tech club</li><li>Mentoring junior builders</li><li>Community software that leaves the classroom</li></ul>',
                'quote' => 'A good workshop ends with work someone can show.',
                'order' => 6,
            ],
            [
                'title' => 'Rapid Builds & Hackathons',
                'slug' => 'yeabsira-rapid-builds',
                'short_description' => 'Short clocks, a clear slice of the product, and first place at Cursor Addis Ababa.',
                'description' => 'KnoQ, at Cursor’s first Addis Ababa hackathon, is the proof. Pick a slice small enough to demo, build it with the team, and tell the story as clearly as the software.',
                'features' => '<ul><li>A scoped slice under a deadline</li><li>Cross-functional pairing</li><li>A demo someone can follow</li><li>AI-assisted product sketches</li></ul>',
                'quote' => 'A tight clock is a design constraint. Treat it that way.',
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
                'name' => 'Kimem Cards',
                'type' => EntityTypeEnum::project,
                'category' => 'Product',
                'link' => '/',
                'description' => "NFC business cards and live profiles, on a Laravel platform I created.\n\nKimem is the product behind this page. A card tap opens a profile the owner can keep current: theme, type, portfolio, gallery, and contact, each tenant on its own site.\n\nI designed the multi-tenant Laravel engine, the public profile, and the studio used after the card is printed. The aim was a profile that stays true when the person changes role, projects, or the way they want to be introduced.\n\nStack: Laravel, multi-tenant theming, NFC tap-to-share, media, and an editing studio.",
                'order' => 1,
            ],
            [
                'name' => 'TETER Trading — backend and delivery',
                'type' => EntityTypeEnum::project,
                'category' => 'Client delivery',
                'link' => 'https://www.linkedin.com/company/tetertrading',
                'description' => "Laravel APIs, CMS, and auth at TETER Trading, kept on a date I can defend.\n\nSince 2025 I have worked there as a backend web developer and junior project manager. The engineering is Laravel and Spatie: APIs, roles, media, and CMS screens. The coordination is the other half — what the client asked for, what the milestone can hold, and what should wait.\n\nI write the feature, then I stay close to the release. A dashboard only the developer understands is still unfinished.\n\nStack: Laravel, Spatie permissions and media, MySQL, and Flutter where the product needs a client.",
                'order' => 2,
            ],
            [
                'name' => 'KnoQ — Cursor Hackathon, Addis Ababa',
                'type' => EntityTypeEnum::project,
                'category' => 'Hackathon',
                'link' => 'https://www.linkedin.com/in/engkukusha',
                'description' => "First place at Cursor’s first Addis Ababa hackathon, with the EdTech product KnoQ.\n\nKnoQ was built on a short clock with a cross-functional team. The useful skill was choosing a slice small enough to demo and clear enough to explain. We left with first place.\n\nI still treat that weekend as a working rule: a tight deadline is a design constraint, and the story has to be as finished as the build.",
                'order' => 3,
            ],
            [
                'name' => 'Freelance Laravel and Flutter builds',
                'type' => EntityTypeEnum::project,
                'category' => 'Freelance',
                'link' => 'https://github.com/Itsyabitaa',
                'description' => "Small-team products taken from a short brief to a version people can use.\n\nIndependent work is where I learned the unglamorous part of delivery: a brief that fits the budget, a stack I can support, and a first version that is allowed to be small. Laravel on the server. Flutter when the product is in someone’s hand.\n\nI stay for the last stretch — the bugs that appear only when a real person uses it.",
                'order' => 4,
            ],
            [
                'name' => 'DDU ICT Club — workshops and campus builders',
                'type' => EntityTypeEnum::project,
                'category' => 'Community',
                'link' => 'https://www.linkedin.com/company/ddu-ict-club',
                'description' => "Workshops and club leadership that get student projects out of the classroom.\n\nAt Dire Dawa University’s ICT Club I handle leadership and public relations. The work is practical: a workshop with a finish line, students who leave with something they built, and communication that makes the next person want to join.\n\nCommunity software counts when it survives the demo.",
                'order' => 5,
            ],
            [
                'name' => 'CodSoft — web development internship',
                'type' => EntityTypeEnum::project,
                'category' => 'Internship',
                'link' => 'https://www.linkedin.com/in/engkukusha',
                'description' => "An early internship in finishing assigned web work on someone else’s schedule.\n\nCodSoft was where I learned to take a ticket, finish it, and hand it back clean. Frontend and backend fundamentals, on a cadence I did not set. It stays on the record because the habit stuck: assigned work, finished work.",
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
                'description' => 'Founder and platform creator',
                'order' => 1,
            ],
            [
                'name' => 'TETER Trading',
                'type' => EntityTypeEnum::partner,
                'description' => 'Backend web developer and junior project coordination',
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
                'description' => 'Club leadership, public relations, and student builders',
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
            'subtitle' => 'Portfolio',
            'title' => 'Platforms, client systems, and a product people can tap',
            'description' => 'Kimem Cards, delivery at TETER Trading, and a first-place finish at Cursor’s Addis Ababa hackathon.',
            'text_link' => 'Open the portfolio',
            'button_link' => '/portfolio',
            'order' => 1,
            'status' => StatusEnum::active,
        ]);
        Hero::create([
            'organization_id' => $org->id,
            'subtitle' => 'How I work',
            'title' => 'Clear scope, readable code, and a date I can stand behind',
            'description' => 'Engineering at TETER Trading and junior project management in the same week.',
            'text_link' => 'About me',
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
                'description' => 'Navigation for the personal profile, with the portfolio first',
            ]
        );

        MenuItem::where('menu_id', $menu->id)->forceDelete();
        foreach ([
            ['title' => 'Home', 'url' => '/', 'order_number' => 1],
            ['title' => 'Work', 'url' => '/portfolio', 'order_number' => 2],
            ['title' => 'Me', 'url' => '/about', 'order_number' => 3],
            ['title' => 'Gallery', 'url' => '/our-services', 'order_number' => 4],
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
