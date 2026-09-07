<?php

namespace Database\Seeders;

use App\Enums\MenuLocationEnum;
use App\Enums\StatusEnum;
use App\Models\Hero;
use App\Models\MenuItem;
use App\Models\MenuLocation;
use App\Models\Organization;
use App\Models\OrganizationContact;
use App\Models\SocialRef;
use App\Models\User;
use Illuminate\Database\Seeder;

class YabtsegaAsfawSeeder extends Seeder
{
    public function run(): void
    {
        $phone = config('seo.platform.support_phone', '+251911223344');
        $whatsapp = preg_replace('/[^0-9]/', '', config('seo.platform.support_whatsapp', $phone));
        $logoPath = database_path('seeders/media/teter-mark.png');

        $org = Organization::updateOrCreate(
            ['slug' => 'yabtsega-asfaw'],
            [
                'title' => 'Yabtsega Asfaw Legese',
                'tagline' => 'Senior Marketing Manager · TETER',
                'meta_description' => 'Yabtsega Asfaw Legese — Senior Marketing Manager at TETER. Brand, campaigns, and relationships.',
                'address' => 'Addis Ababa, Ethiopia',
                'status' => 'active',
                'theme' => [
                    'bg' => '#fff8f1',
                    'surface' => '#ffffff',
                    'ink' => '#2a170c',
                    'muted' => '#7a5340',
                    'line' => '#f0ddcc',
                    'accent' => '#e67e22',
                    'accent_dark' => '#9a4a12',
                    'accent_soft' => 'rgba(230, 126, 34, 0.12)',
                    'dark' => '#3b2414',
                    'font_display' => 'Fraunces',
                    'font_body' => 'Outfit',
                    'brand_font_family' => 'Fraunces',
                    'brand_font_weight' => '700',
                    'brand_letter_spacing' => '-0.03em',
                    'tagline_font_family' => 'Outfit',
                    'tagline_font_weight' => '500',
                    'nav_font_family' => 'Outfit',
                    'nav_font_weight' => '500',
                    'show_logo' => true,
                    'show_header_logo' => true,
                    'show_favicon' => true,
                    'show_brand_text' => true,
                    'show_tagline' => true,
                    'show_header_cta' => true,
                    'header_cta_text' => 'Contact',
                    'header_cta_url' => '/contact',
                    'show_address' => true,
                    'show_opening_hours' => false,
                    'show_po_box' => false,
                    'show_email' => true,
                    'show_phone' => true,
                    'show_social_links' => true,
                    'show_contact_bar' => true,
                    'show_footer_nav' => true,
                    'show_footer_contact' => true,
                    'show_footer_credit' => true,
                    'footer_credit_text' => 'TETER',
                    'footer_credit_url' => 'https://tetercreatives.com',
                    'nav_items' => [
                        ['label' => 'Home', 'url' => '/', 'is_visible' => true, 'target' => '_self', 'show_in_footer' => true],
                        ['label' => 'About', 'url' => '/about', 'is_visible' => true, 'target' => '_self', 'show_in_footer' => true],
                        ['label' => 'Contact', 'url' => '/contact', 'is_visible' => true, 'target' => '_self', 'show_in_footer' => true],
                    ],
                    'home_sections' => [
                        'hero' => [
                            'is_visible' => true,
                            'badge' => 'Senior Marketing Manager · TETER',
                            'subtitle' => 'Senior Marketing Manager',
                            'title' => 'Brands that feel clear. Campaigns that move people.',
                            'description' => 'I lead marketing at TETER — positioning, campaigns, and client relationships that grow the business.',
                            'cta_text' => 'About me',
                            'cta_url' => '/about',
                            'secondary_cta_text' => 'Contact',
                            'secondary_cta_url' => '/contact',
                            'slides' => [
                                [
                                    'eyebrow' => 'Senior Marketing Manager · TETER',
                                    'title' => 'Brands that feel clear. Campaigns that move people.',
                                    'description' => 'I lead marketing at TETER — positioning, campaigns, and client relationships that grow the business.',
                                    'button_label' => 'About me',
                                    'button_url' => '/about',
                                    'media_mode' => 'logo',
                                    'is_visible' => true,
                                ],
                            ],
                        ],
                        'about' => [
                            'is_visible' => true,
                            'layout' => 'me',
                            'eyebrow' => 'About',
                            'kicker' => 'TETER',
                            'portrait_role' => 'Senior Marketing Manager',
                            'title' => 'I grow brands with story, focus, and follow-through.',
                            'description' => 'At TETER I own the marketing rhythm: how we show up, who we speak to, and how a campaign turns into trust.',
                            'cta_text' => 'Get in touch',
                            'cta_url' => '/contact',
                            'points' => [
                                [
                                    'title' => 'Brand',
                                    'description' => 'A clear voice and look that people remember.',
                                ],
                                [
                                    'title' => 'Campaigns',
                                    'description' => 'Work that ships, lands, and can be measured.',
                                ],
                                [
                                    'title' => 'Relationships',
                                    'description' => 'Clients and partners who know they can reach me.',
                                ],
                            ],
                        ],
                        'stats' => ['is_visible' => false],
                        'services' => ['is_visible' => false],
                        'portfolio' => ['is_visible' => false],
                        'team' => ['is_visible' => false],
                        'clients' => ['is_visible' => false],
                        'cta' => [
                            'is_visible' => true,
                            'eyebrow' => 'Let’s talk',
                            'title' => 'Have a brand or campaign in mind?',
                            'description' => 'Call, WhatsApp, or send a short note.',
                            'button_text' => 'Contact',
                            'button_url' => '/contact',
                        ],
                        'creator' => ['is_visible' => false],
                    ],
                    'pages' => [
                        'about' => [
                            'layout' => 'me',
                            'eyebrow' => 'About',
                            'title' => 'About',
                            'description' => 'Senior Marketing Manager at TETER.',
                            'intro' => [
                                'eyebrow' => 'About',
                                'kicker' => 'TETER',
                                'portrait_role' => 'Senior Marketing Manager',
                                'title' => 'Hello — I’m Yabtsega Asfaw Legese.',
                                'description' => 'I am Senior Marketing Manager at TETER. My work is simple on purpose: a clear brand, campaigns that move, and relationships that last.',
                                'points' => [
                                    [
                                        'title' => 'Positioning',
                                        'icon' => 'bi bi-bullseye',
                                        'description' => 'Who we are, who it is for, and why it matters now.',
                                    ],
                                    [
                                        'title' => 'Campaigns',
                                        'icon' => 'bi bi-megaphone',
                                        'description' => 'From brief to launch — with a story people can follow.',
                                    ],
                                    [
                                        'title' => 'Partnerships',
                                        'icon' => 'bi bi-people',
                                        'description' => 'Clients and collaborators who prefer a direct line.',
                                    ],
                                ],
                            ],
                            'story' => [
                                'eyebrow' => 'How I work',
                                'title' => 'A little more',
                                'panels' => [
                                    [
                                        'title' => 'The marketer',
                                        'description' => 'I start with the audience, then the offer, then the channel. Most of the craft is making the message easy to say out loud.',
                                    ],
                                    [
                                        'title' => 'TETER',
                                        'description' => 'At TETER I keep marketing close to delivery — so what we promise is what the team can actually ship.',
                                    ],
                                ],
                            ],
                            'show_stats' => false,
                            'show_team' => false,
                            'show_clients' => false,
                            'show_cta' => true,
                        ],
                        'contact' => [
                            'eyebrow' => 'Contact',
                            'title' => 'Say hello',
                            'description' => 'Call, WhatsApp, or send a message.',
                            'intro' => 'Leave a short note — I reply on the same channels you see on this card.',
                        ],
                    ],
                ],
            ]
        );

        $admin = User::query()->where('email', 'admin@admin.com')->first() ?? User::query()->first();
        if ($admin) {
            $org->users()->syncWithoutDetaching([
                $admin->id => ['role' => 'owner'],
            ]);
        }

        if (is_file($logoPath)) {
            $org->clearMediaCollection('logo');
            $org->addMedia($logoPath)->preservingOriginal()->toMediaCollection('logo');
            $org->clearMediaCollection('favicon');
            $org->addMedia($logoPath)->preservingOriginal()->toMediaCollection('favicon');
        }

        OrganizationContact::where('organization_id', $org->id)->delete();
        foreach ([
            ['type' => 'email', 'value' => 'yabtsega@tetercreatives.com'],
            ['type' => 'phone', 'value' => $phone],
        ] as $contact) {
            OrganizationContact::create([
                'organization_id' => $org->id,
                'type' => $contact['type'],
                'value' => $contact['value'],
                'status' => StatusEnum::active,
            ]);
        }

        SocialRef::where('organization_id', $org->id)->delete();
        foreach ([
            ['title' => 'WhatsApp', 'icon_class' => 'bi bi-whatsapp', 'link' => 'https://wa.me/'.$whatsapp, 'order' => 1],
            ['title' => 'Email', 'icon_class' => 'bi bi-envelope', 'link' => 'mailto:yabtsega@tetercreatives.com', 'order' => 2],
            ['title' => 'TETER', 'icon_class' => 'bi bi-globe', 'link' => 'https://tetercreatives.com', 'order' => 3],
        ] as $social) {
            SocialRef::create([
                'organization_id' => $org->id,
                'title' => $social['title'],
                'icon_class' => $social['icon_class'],
                'link' => $social['link'],
                'order' => $social['order'],
                'status' => StatusEnum::active,
            ]);
        }

        Hero::where('organization_id', $org->id)->delete();
        $hero = Hero::create([
            'organization_id' => $org->id,
            'subtitle' => 'Senior Marketing Manager · TETER',
            'title' => 'Brands that feel clear. Campaigns that move people.',
            'description' => 'I lead marketing at TETER — positioning, campaigns, and client relationships that grow the business.',
            'text_link' => 'About me',
            'button_link' => '/about',
            'order' => 1,
            'status' => StatusEnum::active,
        ]);

        if (is_file($logoPath)) {
            $hero->clearMediaCollection('image');
            $hero->addMedia($logoPath)->preservingOriginal()->toMediaCollection('image');
        }

        $menu = MenuLocation::updateOrCreate(
            [
                'organization_id' => $org->id,
                'location' => MenuLocationEnum::Navbar,
            ],
            [
                'name' => 'Yabtsega Navigation',
                'slug' => 'yabtsega-asfaw-nav',
                'description' => 'Home, About, Contact only',
            ]
        );

        MenuItem::where('menu_id', $menu->id)->forceDelete();
        foreach ([
            ['title' => 'Home', 'url' => '/', 'order_number' => 1],
            ['title' => 'About', 'url' => '/about', 'order_number' => 2],
            ['title' => 'Contact', 'url' => '/contact', 'order_number' => 3],
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
