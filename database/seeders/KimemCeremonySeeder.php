<?php

namespace Database\Seeders;

use App\Enums\EntityTypeEnum;
use App\Enums\MenuLocationEnum;
use App\Enums\StatusEnum;
use App\Models\Entity;
use App\Models\MenuItem;
use App\Models\MenuLocation;
use App\Models\Organization;
use App\Models\OrganizationContact;
use App\Models\Service;
use App\Models\SocialRef;
use App\Models\User;
use Illuminate\Database\Seeder;

class KimemCeremonySeeder extends Seeder
{
    public function run(): void
    {
        $org = Organization::updateOrCreate(
            ['slug' => 'kimem'],
            [
                'title' => 'Kimem',
                'tagline' => 'Creating moments of faith. Connecting hearts.',
                'meta_description' => 'Kimem plans weddings and sacred celebrations with quiet care, from the first conversation to the last dance.',
                'address' => 'Addis Ababa, Ethiopia',
                'status' => 'active',
                'theme' => $this->theme(),
            ]
        );

        $admin = User::query()->where('email', 'admin@admin.com')->first() ?? User::query()->first();
        if ($admin) {
            $org->users()->syncWithoutDetaching([
                $admin->id => ['role' => 'owner'],
            ]);
        }

        OrganizationContact::where('organization_id', $org->id)->delete();
        foreach ([
            ['type' => 'email', 'value' => 'hello@kimem.test'],
            ['type' => 'phone', 'value' => '+251911000000'],
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
            ['title' => 'Instagram', 'link' => 'https://instagram.com', 'icon_class' => 'bi bi-instagram', 'order' => 1],
            ['title' => 'Facebook', 'link' => 'https://facebook.com', 'icon_class' => 'bi bi-facebook', 'order' => 2],
            ['title' => 'YouTube', 'link' => 'https://youtube.com', 'icon_class' => 'bi bi-youtube', 'order' => 3],
        ] as $social) {
            SocialRef::create(array_merge($social, [
                'organization_id' => $org->id,
                'status' => StatusEnum::active,
            ]));
        }

        $services = [
            [
                'title' => 'Intimate Event Planning',
                'slug' => 'kimem-intimate-event-planning',
                'short_description' => 'A private ceremony shaped around your faith, your families, and the promise you are making.',
                'description' => 'We plan gatherings that stay close: the vows, the meal, the people in the room, and the order of the day.',
                'order' => 1,
            ],
            [
                'title' => 'Venue Coordination',
                'slug' => 'kimem-venue-coordination',
                'short_description' => 'The place, the timing, and the flow of guests, held together so the celebration can breathe.',
                'description' => 'From the first walk-through to the last light, we coordinate the room, the schedule, and the people who make it ready.',
                'order' => 2,
            ],
            [
                'title' => 'Vendor & Decorations',
                'slug' => 'kimem-vendor-decorations',
                'short_description' => 'Florals, dress, music, and the makers around your day, chosen to feel like one story.',
                'description' => 'We gather the vendors and the decoration so every table, garment, and song belongs to the same celebration.',
                'order' => 3,
            ],
        ];

        Service::where('organization_id', $org->id)->forceDelete();
        foreach ($services as $service) {
            Service::withTrashed()->updateOrCreate(
                ['slug' => $service['slug']],
                array_merge($service, [
                    'organization_id' => $org->id,
                    'status' => StatusEnum::active,
                    'deleted_at' => null,
                ])
            );
        }

        Entity::where('organization_id', $org->id)->delete();
        foreach ([
            ['name' => 'Dawit & Elsa', 'category' => 'Wedding', 'description' => 'A ceremony of faith and family. Add the photographs from Home sections, Spotlight.', 'order' => 1],
            ['name' => 'Nahum', 'category' => 'Wedding', 'description' => 'A celebration from the picture grid. Replace this note with the story when the photos are in.', 'order' => 2],
        ] as $project) {
            Entity::create(array_merge($project, [
                'organization_id' => $org->id,
                'type' => EntityTypeEnum::project,
                'status' => StatusEnum::active,
            ]));
        }

        $menu = MenuLocation::updateOrCreate(
            [
                'organization_id' => $org->id,
                'location' => MenuLocationEnum::Navbar,
            ],
            [
                'name' => 'Kimem navigation',
                'slug' => 'kimem-nav',
                'description' => 'Home, about, work, blog, and contact',
            ]
        );

        MenuItem::where('menu_id', $menu->id)->forceDelete();
        foreach ([
            ['title' => 'Home', 'url' => '/', 'order_number' => 1],
            ['title' => 'About', 'url' => '/about', 'order_number' => 2],
            ['title' => 'Work', 'url' => '/portfolio', 'order_number' => 3],
            ['title' => 'Blog', 'url' => '/portfolio', 'order_number' => 4],
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

    private function theme(): array
    {
        return [
            'bg' => '#0c0b09',
            'surface' => '#141310',
            'ink' => '#f4efe4',
            'muted' => '#b7ab96',
            'line' => 'rgba(198, 161, 90, 0.45)',
            'accent' => '#c6a15a',
            'accent_dark' => '#a6843e',
            'accent_soft' => 'rgba(198, 161, 90, 0.16)',
            'dark' => '#070605',
            'font_display' => 'Playfair Display',
            'font_body' => 'Outfit',
            'brand_font_family' => 'Playfair Display',
            'brand_font_weight' => '500',
            'brand_letter_spacing' => '0.18em',
            'nav_font_family' => 'Outfit',
            'nav_font_weight' => '500',
            'nav_spacing' => '0.7rem 0.85rem',
            'layout' => 'ceremony',
            'footer_style' => 'explore',
            'footer_explore_label' => 'Explore',
            'image_shape' => 'rounded-sm',
            'show_logo' => true,
            'show_header_logo' => true,
            'show_footer_logo' => false,
            'show_brand_text' => true,
            'show_header_brand_text' => true,
            'show_footer_brand_text' => false,
            'header_display_name' => 'Kimem',
            'footer_display_name' => 'Kimem',
            'show_tagline' => false,
            'show_header_cta' => true,
            'header_cta_text' => 'Book a consult',
            'header_cta_url' => '/contact',
            'show_address' => true,
            'show_opening_hours' => false,
            'show_po_box' => false,
            'show_email' => true,
            'show_phone' => true,
            'show_social_links' => true,
            'show_contact_bar' => false,
            'show_footer_nav' => true,
            'show_footer_contact' => false,
            'show_footer_social' => false,
            'show_footer_credit' => false,
            'section_order' => ['hero', 'about', 'services', 'spotlight', 'gallery', 'cta', 'inquiry', 'portfolio', 'stats', 'team', 'clients'],
            'nav_items' => [
                ['label' => 'Home', 'url' => '/', 'is_visible' => true, 'target' => '_self', 'show_in_footer' => true],
                ['label' => 'About', 'url' => '/about', 'is_visible' => true, 'target' => '_self', 'show_in_footer' => true],
                ['label' => 'Work', 'url' => '/portfolio', 'is_visible' => true, 'target' => '_self', 'show_in_footer' => true],
                ['label' => 'Blog', 'url' => '/portfolio', 'is_visible' => true, 'target' => '_self', 'show_in_footer' => true],
                ['label' => 'Contact', 'url' => '/contact', 'is_visible' => true, 'target' => '_self', 'show_in_footer' => true],
            ],
            'home_sections' => [
                'creator' => ['is_visible' => false],
                'hero' => [
                    'is_visible' => true,
                    'style' => 'backdrop',
                    'show_brand_text' => false,
                    'show_brand_logo' => false,
                    'badge' => '',
                    'title' => 'Creating Moments of Faith. Connecting Hearts.',
                    'description' => 'Heartfelt planning for ceremonies that honor faith, family, and the promise you make to each other.',
                    'cta_text' => 'Plan your event',
                    'cta_url' => '#inquiry',
                    'secondary_cta_text' => 'Explore our services',
                    'secondary_cta_url' => '#services',
                    'background_image' => null,
                    'background_opacity' => 78,
                    'background_shade' => 46,
                    'background_focus_x' => 50,
                    'background_focus_y' => 35,
                    'slides' => [[
                        'title' => 'Creating Moments of Faith. Connecting Hearts.',
                        'subtitle' => '',
                        'description' => 'Heartfelt planning for ceremonies that honor faith, family, and the promise you make to each other.',
                        'button_label' => 'Plan your event',
                        'button_url' => '#inquiry',
                        'is_visible' => true,
                    ]],
                ],
                'about' => [
                    'is_visible' => true,
                    'layout' => 'editorial',
                    'eyebrow' => 'About Kimem',
                    'title' => 'More Than an Event. A Meaningful Experience.',
                    'paragraph_1' => 'Kimem shapes weddings and sacred celebrations with quiet care. From the first conversation to the last dance, we hold the details so you can stay present for the people you love.',
                    'paragraph_2' => '',
                    'points' => [],
                ],
                'services' => [
                    'is_visible' => true,
                    'layout' => 'outline',
                    'eyebrow' => 'Our services',
                    'title' => '',
                    'description' => '',
                    'card_link_text' => 'Learn more',
                    'icons' => [
                        'kimem-intimate-event-planning' => 'bi bi-stars',
                        'kimem-venue-coordination' => 'bi bi-geo-alt',
                        'kimem-vendor-decorations' => 'bi bi-flower1',
                    ],
                ],
                'spotlight' => [
                    'is_visible' => true,
                    'overlay' => 'Dawit & Elsa',
                    'overlay_sub' => '',
                    'eyebrow' => 'Meet the couple',
                    'title' => 'A promise, witnessed',
                    'description' => 'Every celebration we plan starts with the people at the center of it.',
                    'points' => [
                        ['title' => 'A ceremony held in faith and family', 'description' => ''],
                        ['title' => 'Rooms prepared for the people who matter', 'description' => ''],
                        ['title' => 'A day that still feels like yours', 'description' => ''],
                    ],
                    'frames' => [
                        ['image' => null, 'alt' => 'Lead portrait'],
                        ['image' => null, 'alt' => 'Ceremony detail'],
                        ['image' => null, 'alt' => 'Celebration'],
                    ],
                ],
                'gallery' => [
                    'is_visible' => true,
                    'eyebrow' => 'Pictures every one loves',
                    'title' => '',
                    'description' => '',
                    'tiles' => [
                        ['image' => null, 'title' => 'Wedding', 'subtitle' => 'Nahum', 'span' => 'feature'],
                        ['image' => null, 'title' => '', 'subtitle' => '', 'span' => 'tile'],
                        ['image' => null, 'title' => '', 'subtitle' => '', 'span' => 'tile'],
                        ['image' => null, 'title' => '', 'subtitle' => '', 'span' => 'tile'],
                        ['image' => null, 'title' => '', 'subtitle' => '', 'span' => 'tile'],
                    ],
                ],
                'stats' => ['is_visible' => false],
                'portfolio' => [
                    'is_visible' => false,
                    'eyebrow' => 'Selected celebrations',
                    'title' => 'Work',
                    'description' => 'Stories from the days we have planned.',
                ],
                'clients' => ['is_visible' => false],
                'team' => ['is_visible' => false],
                'cta' => [
                    'is_visible' => true,
                    'style' => 'center',
                    'title' => "Let's create something meaningful",
                    'eyebrow' => 'Your Vision. Our Expertise. One Unforgettable Experience.',
                    'description' => 'Tell us the day you are hoping for. We will help you shape it, then carry the details.',
                    'button_text' => 'Get started',
                    'button_url' => '#inquiry',
                ],
                'inquiry' => [
                    'is_visible' => true,
                    'eyebrow' => 'Contact us',
                    'title' => 'We are open to making Love and Dance',
                    'description' => 'Share the date, the place, and what the day should feel like.',
                    'button_text' => 'Send message',
                ],
            ],
            'pages' => [
                'about' => [
                    'eyebrow' => 'About Kimem',
                    'title' => 'More than an event',
                    'description' => 'Weddings and sacred celebrations planned with quiet care.',
                    'intro' => [
                        'eyebrow' => 'About Kimem',
                        'title' => 'More Than an Event. A Meaningful Experience.',
                        'description' => 'Kimem shapes weddings and sacred celebrations with quiet care. From the first conversation to the last dance, we hold the details so you can stay present for the people you love.',
                    ],
                ],
                'contact' => [
                    'eyebrow' => 'Contact us',
                    'title' => 'Book a consult',
                    'description' => 'Tell us about the celebration you are planning.',
                    'intro' => 'Tell us about the celebration you are planning. We will answer with the next step.',
                ],
                'services' => [
                    'eyebrow' => 'Our services',
                    'title' => 'How we plan the day',
                    'description' => 'Intimate planning, venue coordination, and the vendors around your celebration.',
                ],
                'portfolio' => [
                    'eyebrow' => 'Work',
                    'title' => 'Celebrations',
                    'description' => 'A few of the days we have been trusted to hold.',
                ],
            ],
        ];
    }
}
