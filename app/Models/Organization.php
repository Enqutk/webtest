<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Organization extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'tagline',
        'meta_description',
        'theme',
        'po_box',
        'address',
        'opening_hours',
        'map_url',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
        'opening_hours' => 'array',
        'theme' => 'array',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']);

        $this->addMediaCollection('favicon')
            ->singleFile()
            ->acceptsMimeTypes(['image/png', 'image/x-icon', 'image/vnd.microsoft.icon', 'image/jpeg', 'image/webp', 'image/svg+xml']);
    }

    public function getLogoUrlAttribute(): ?string
    {
        $url = $this->getFirstMediaUrl('logo');

        return $url !== '' ? $url : null;
    }

    public function getFaviconUrlAttribute(): ?string
    {
        $url = $this->getFirstMediaUrl('favicon');

        return $url !== '' ? $url : null;
    }

    public static function defaultTheme(): array
    {
        return [
            'accent' => '#0f766e',
            'accent_dark' => '#0b5f58',
            'ink' => '#10211f',
            'muted' => '#5a6b68',
            'bg' => '#f3f6f5',
            'surface' => '#ffffff',
            'line' => '#d7e0dd',
            'dark' => '#0a1615',
            'font_display' => 'Fraunces',
            'font_body' => 'Outfit',
            'show_brand_text' => true,
            'show_logo' => true,
            'show_favicon' => true,
            'show_tagline' => true,
            'show_po_box' => true,
            'show_header_logo' => true,
            'show_header_cta' => true,
            'header_cta_text' => 'Get in touch',
            'header_cta_url' => '/contact',
            'show_address' => true,
            'show_map' => true,
            'show_email' => true,
            'show_phone' => true,
            'show_social_links' => true,
            'show_opening_hours' => true,
            'show_footer_tagline' => true,
            'show_footer_social' => true,
            'show_footer_nav' => true,
            'show_footer_contact' => true,
            'show_footer_credit' => true,

            // Brand Typography & Style
            'brand_font_family' => null,
            'brand_font_size' => '1.45rem',
            'brand_font_weight' => '700',
            'brand_color' => null,
            'brand_letter_spacing' => '-0.03em',

            // Tagline Typography & Style
            'tagline_font_family' => null,
            'tagline_font_size' => '0.95rem',
            'tagline_font_style' => 'normal',
            'tagline_font_weight' => '400',
            'tagline_color' => null,

            // Navigation Links & Menu Items
            'nav_font_family' => null,
            'nav_font_weight' => '500',
            'nav_spacing' => '0.55rem 0.9rem',
            'nav_items' => self::defaultNavItems(),

            // Home Page Sections Customizer
            'home_sections' => self::defaultHomeSections(),
        ];
    }

    public static function defaultNavItems(): array
    {
        try {
            $existing = MenuItem::query()
                ->whereNull('parent_id')
                ->orderBy('order_number')
                ->get();

            if ($existing->isNotEmpty()) {
                return $existing->map(fn (MenuItem $item) => [
                    'label' => $item->title,
                    'url' => $item->url ?: '/',
                    'is_visible' => true,
                    'target' => $item->target ?: '_self',
                ])->all();
            }
        } catch (\Throwable $e) {
            // fallback
        }

        return [
            ['label' => 'Home', 'url' => '/', 'is_visible' => true, 'target' => '_self'],
            ['label' => 'About', 'url' => '/about', 'is_visible' => true, 'target' => '_self'],
            ['label' => 'Services', 'url' => '/our-services', 'is_visible' => true, 'target' => '_self'],
            ['label' => 'Portfolio', 'url' => '/portfolio', 'is_visible' => true, 'target' => '_self'],
            ['label' => 'Contact', 'url' => '/contact', 'is_visible' => true, 'target' => '_self'],
        ];
    }

    public static function defaultHomeSections(): array
    {
        return [
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
            ],
            'about' => [
                'is_visible' => true,
                'eyebrow' => 'Who we are',
                'title' => 'Water expertise for living landscapes',
                'description' => 'We combine technical hydrology, sustainable agriculture, and community governance to design water infrastructure that lasts generations.',
                'points' => [
                    ['title' => 'Design & Build', 'description' => 'Turnkey irrigation schemes, boreholes, and piped distribution networks.'],
                    ['title' => 'Climate Resilience', 'description' => 'Flood control, catchment rehabilitation, and water harvesting structures.'],
                    ['title' => 'Governance & Training', 'description' => 'Capacity building for community water management committees and utilities.'],
                ],
            ],
            'services' => [
                'is_visible' => true,
                'eyebrow' => 'What we deliver',
                'title' => 'Specialized engineering across the water cycle',
                'description' => 'From feasibility studies to long-term asset management, our services address critical water challenges.',
                'cta_text' => 'View all services',
                'cta_url' => '/our-services',
            ],
            'stats' => [
                'is_visible' => true,
                'eyebrow' => 'By the numbers',
                'title' => 'Impact that compounds across communities',
                'subtitle' => 'Measured outcomes delivered through disciplined engineering and long-term community stewardship.',
                'items' => [
                    ['value' => '25+', 'label' => 'Counties served', 'description' => 'Across East Africa'],
                    ['value' => '140k+', 'label' => 'People with clean water', 'description' => 'Sustainable access'],
                    ['value' => '98%', 'label' => 'Scheme uptime', 'description' => 'Reliable operations'],
                    ['value' => '65+', 'label' => 'Completed projects', 'description' => 'On time & budget'],
                ],
            ],
            'portfolio' => [
                'is_visible' => true,
                'eyebrow' => 'Selected projects',
                'title' => 'Engineered systems operating in the field',
                'description' => 'A showcase of recent irrigation schemes, dam rehabilitations, and municipal water supply projects.',
                'cta_text' => 'View full portfolio',
                'cta_url' => '/portfolio',
            ],
            'clients' => [
                'is_visible' => true,
                'eyebrow' => 'Trusted partners',
                'title' => 'Organizations we work alongside',
                'description' => 'Partnering with governments, development agencies, private developers, and local communities.',
            ],
            'team' => [
                'is_visible' => true,
                'eyebrow' => 'Leadership & Team',
                'title' => 'Experienced engineers & hydrologists',
                'description' => 'Multidisciplinary experts dedicated to delivering technical precision and community impact.',
                'cta_text' => 'Meet the entire team',
                'cta_url' => '/about#team',
            ],
            'cta' => [
                'is_visible' => true,
                'title' => 'Have a project in mind?',
                'description' => 'Climate-smart irrigation, rural WASH, flood resilience, and water-resource GIS across East Africa.',
                'button_text' => 'Start a conversation',
                'button_url' => '/contact',
            ],
        ];
    }

    protected static function booted(): void
    {
        static::saved(function () {
            try {
                app(\App\Services\NavigationService::class)->clearCache();
            } catch (\Throwable $e) {
                // ignore
            }
        });
    }

    public static function getFontWeightOptions(): array
    {
        return [
            '300' => '300 (Light)',
            '400' => '400 (Regular)',
            '500' => '500 (Medium)',
            '600' => '600 (Semi-Bold)',
            '700' => '700 (Bold)',
            '800' => '800 (Extra-Bold)',
        ];
    }

    public static function getFontStyleOptions(): array
    {
        return [
            'normal' => 'Normal',
            'italic' => 'Italic',
        ];
    }

    public static function getFontOptions(): array
    {
        return [
            'Outfit' => 'Outfit (Modern Sans-serif)',
            'Fraunces' => 'Fraunces (Warm Editorial Serif)',
            'Plus Jakarta Sans' => 'Plus Jakarta Sans (Clean Modern Sans)',
            'Inter' => 'Inter (Geometric UI Sans)',
            'Poppins' => 'Poppins (Rounded Modern Sans)',
            'Montserrat' => 'Montserrat (Classic Geometric Sans)',
            'Playfair Display' => 'Playfair Display (Elegant Serif)',
            'Lora' => 'Lora (Contemporary Literary Serif)',
            'Roboto' => 'Roboto (Clean Standard Sans)',
            'Open Sans' => 'Open Sans (Neutral Sans)',
            'DM Sans' => 'DM Sans (Low-contrast Sans)',
            'Cinzel' => 'Cinzel (Classical Display Serif)',
            'Space Grotesk' => 'Space Grotesk (Tech Display)',
            'Syne' => 'Syne (Bold Expressive Display)',
        ];
    }

    public static function getGoogleFontQuery(string $font): string
    {
        return match ($font) {
            'Outfit' => 'family=Outfit:wght@400;500;600;700;800',
            'Fraunces' => 'family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700;9..144,800',
            'Plus Jakarta Sans' => 'family=Plus+Jakarta+Sans:wght@400;500;600;700;800',
            'Inter' => 'family=Inter:wght@400;500;600;700;800',
            'Poppins' => 'family=Poppins:wght@400;500;600;700;800',
            'Montserrat' => 'family=Montserrat:wght@400;500;600;700;800',
            'Playfair Display' => 'family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400',
            'Lora' => 'family=Lora:ital,wght@0,400;0,500;0,600;0,700',
            'Roboto' => 'family=Roboto:wght@400;500;700',
            'Open Sans' => 'family=Open+Sans:wght@400;500;600;700',
            'DM Sans' => 'family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,700',
            'Cinzel' => 'family=Cinzel:wght@400;600;700;800',
            'Space Grotesk' => 'family=Space+Grotesk:wght@400;500;600;700',
            'Syne' => 'family=Syne:wght@400;600;700;800',
            default => 'family=' . str_replace(' ', '+', $font) . ':wght@400;600;700',
        };
    }

    public static function getGoogleFontsUrl(array $fonts = []): string
    {
        $unique = array_unique(array_filter($fonts));
        if (empty($unique)) {
            $unique = ['Fraunces', 'Outfit'];
        }

        $queries = array_map(fn ($f) => self::getGoogleFontQuery($f), $unique);

        return 'https://fonts.googleapis.com/css2?' . implode('&', $queries) . '&display=swap';
    }

    public static function getAllGoogleFontsUrl(): string
    {
        return self::getGoogleFontsUrl(array_keys(self::getFontOptions()));
    }

    public static function getFontOptionsWithPreview(): array
    {
        $options = [];
        $fontDetails = [
            'Outfit' => ['label' => 'Outfit', 'sub' => 'Modern Sans-serif'],
            'Fraunces' => ['label' => 'Fraunces', 'sub' => 'Warm Editorial Serif'],
            'Plus Jakarta Sans' => ['label' => 'Plus Jakarta Sans', 'sub' => 'Clean Modern Sans'],
            'Inter' => ['label' => 'Inter', 'sub' => 'Geometric UI Sans'],
            'Poppins' => ['label' => 'Poppins', 'sub' => 'Rounded Modern Sans'],
            'Montserrat' => ['label' => 'Montserrat', 'sub' => 'Classic Geometric Sans'],
            'Playfair Display' => ['label' => 'Playfair Display', 'sub' => 'Elegant Serif'],
            'Lora' => ['label' => 'Lora', 'sub' => 'Contemporary Literary Serif'],
            'Roboto' => ['label' => 'Roboto', 'sub' => 'Clean Standard Sans'],
            'Open Sans' => ['label' => 'Open Sans', 'sub' => 'Neutral Sans'],
            'DM Sans' => ['label' => 'DM Sans', 'sub' => 'Low-contrast Sans'],
            'Cinzel' => ['label' => 'Cinzel', 'sub' => 'Classical Display Serif'],
            'Space Grotesk' => ['label' => 'Space Grotesk', 'sub' => 'Tech Display'],
            'Syne' => ['label' => 'Syne', 'sub' => 'Bold Expressive Display'],
        ];

        foreach ($fontDetails as $name => $info) {
            $options[$name] = "<span style=\"font-family: '{$name}', sans-serif; font-size: 1.05rem; letter-spacing: 0.01em; display: inline-flex; align-items: baseline; gap: 0.4rem;\"><strong>{$info['label']}</strong> <span style=\"font-size: 0.78rem; opacity: 0.6; font-family: sans-serif; font-weight: normal;\">({$info['sub']})</span></span>";
        }

        return $options;
    }

    /**
     * Merged theme with derived soft accent for CSS variables.
     *
     * @return array<string, mixed>
     */
    public function resolvedTheme(): array
    {
        $theme = array_merge(self::defaultTheme(), array_filter(
            $this->theme ?? [],
            fn ($value) => $value !== null && $value !== ''
        ));

        if (empty($this->theme['accent_dark'] ?? null) && ! empty($theme['accent'])) {
            $theme['accent_dark'] = self::shadeHex($theme['accent'], -18);
        }

        $theme['accent_soft'] = self::hexToRgba($theme['accent'], 0.12);

        return $theme;
    }

    public static function getDayOptions(): array
    {
        return [
            'mon' => 'Monday',
            'tue' => 'Tuesday',
            'wed' => 'Wednesday',
            'thu' => 'Thursday',
            'fri' => 'Friday',
            'sat' => 'Saturday',
            'sun' => 'Sunday',
        ];
    }

    public static function hexToRgba(string $hex, float $alpha = 1.0): string
    {
        $hex = ltrim(trim($hex), '#');

        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }

        if (strlen($hex) !== 6 || ! ctype_xdigit($hex)) {
            return 'rgba(15, 118, 110, '.$alpha.')';
        }

        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        return sprintf('rgba(%d, %d, %d, %s)', $r, $g, $b, rtrim(rtrim(number_format($alpha, 3, '.', ''), '0'), '.'));
    }

    public static function shadeHex(string $hex, int $percent): string
    {
        $hex = ltrim(trim($hex), '#');

        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }

        if (strlen($hex) !== 6 || ! ctype_xdigit($hex)) {
            return '#0b5f58';
        }

        $out = '#';

        for ($i = 0; $i < 3; $i++) {
            $channel = hexdec(substr($hex, $i * 2, 2));
            $channel = (int) max(0, min(255, round($channel + ($channel * $percent / 100))));
            $out .= str_pad(dechex($channel), 2, '0', STR_PAD_LEFT);
        }

        return $out;
    }
}
