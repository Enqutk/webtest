<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Organization extends Model implements HasMedia, \Filament\Models\Contracts\HasName, \Filament\Models\Contracts\HasCurrentTenantLabel
{
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'domain',
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

    public static function resolveCurrent(): self
    {
        if (request()->filled('org')) {
            $org = self::find(request('org'));
            if ($org) {
                session(['active_organization_id' => $org->id]);
                return $org;
            }
        }

        if (session()->has('active_organization_id')) {
            $org = self::find(session('active_organization_id'));
            if ($org) {
                return $org;
            }
        }

        $first = self::first();
        if ($first) {
            session(['active_organization_id' => $first->id]);
            return $first;
        }

        $created = self::create([
            'title' => 'My Organization',
            'slug' => 'default',
            'status' => 'active',
            'theme' => self::defaultTheme(),
        ]);
        session(['active_organization_id' => $created->id]);
        return $created;
    }

    public function getFilamentName(): string
    {
        return $this->title ?? 'Organization';
    }

    public function getCurrentTenantLabel(): string
    {
        return 'Active Organization';
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'organization_user')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function services(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function teams(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Team::class);
    }

    public function entities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Entity::class);
    }

    public function heroes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Hero::class);
    }

    public function pages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Page::class);
    }

    public function menuLocations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MenuLocation::class);
    }

    public function socialRefs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SocialRef::class);
    }

    public function contacts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrganizationContact::class);
    }

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

            // Picture / Image Shape Style
            'image_shape' => 'rounded-xl',

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
                'slides' => self::defaultHeroSlides(),
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

    public static function defaultHeroSlides(): array
    {
        try {
            $existing = Hero::where('status', \App\Enums\StatusEnum::active)
                ->with('media')
                ->orderBy('order')
                ->get();

            if ($existing->isNotEmpty()) {
                return $existing->map(function (Hero $h) {
                    $media = $h->getFirstMedia('image');
                    $rel = null;
                    if ($media) {
                        $rel = str_replace(url('/storage') . '/', '', $media->getUrl());
                        $rel = str_replace('/storage/', '', $rel);
                    }
                    return [
                        'title' => $h->title,
                        'subtitle' => $h->subtitle,
                        'description' => $h->description,
                        'image' => $rel ? [$rel => $rel] : [],
                        'text_link' => $h->text_link ?: 'Explore services',
                        'button_link' => $h->button_link ?: '/our-services',
                        'is_visible' => true,
                    ];
                })->all();
            }
        } catch (\Throwable $e) {
            // fallback
        }

        return [
            [
                'title' => 'Water systems that feed communities',
                'subtitle' => 'Irrigation · WASH · Resilience',
                'description' => 'Precision irrigation and rural water infrastructure engineered for climate resilience.',
                'image' => [],
                'text_link' => 'Explore services',
                'button_link' => '/our-services',
                'is_visible' => true,
            ],
        ];
    }

    protected static function booted(): void
    {
        static::saved(function () {
            try {
                app(\App\Services\NavigationService::class)->clearCache();
                \Illuminate\Support\Facades\Cache::flush();
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

    public static function imageShapeOptions(bool $includeInherit = false): array
    {
        $options = [];
        if ($includeInherit) {
            $options['inherit'] = '🔄 Use Global Picture Shape (Default)';
        }

        return array_merge($options, [
            'star' => '⭐ Star (5-Point Geometric Star)',
            'star-8' => '✨ Starburst (8-Point Star Diamond)',
            'diamond' => '💎 Diamond / Rhombus',
            'hexagon' => '🔷 Hexagon (6-Sided Modern)',
            'octagon' => '🛑 Octagon (8-Sided Architectural)',
            'shield' => '🛡️ Shield / Crest Badge',
            'blob' => '🫧 Organic Fluid Blob',
            'arch' => '🏛️ Architectural Arch (Curved top 120px)',
            'arch-full' => '⛪ Cathedral Roman Arch (Full dome top)',
            'circle' => '⚪ Circle / Round (Full Circular)',
            'pill' => '💊 Capsule / Full Pill (9999px)',
            'squircle' => '💠 Organic Squircle (28% curve)',
            'rounded-xl' => '🟩 Card Rounded (20px - Premium Soft)',
            'rounded-2xl' => '🟢 Ultra Soft (28px - Friendly)',
            'rounded-3xl' => '🔵 Super Curvy (36px - Bold)',
            'rounded-lg' => '▢ Smooth Rounded (14px - Modern)',
            'rounded-md' => '◻️ Standard Rounded (8px - Classic)',
            'rounded-sm' => '◽ Subtle Rounded (4px - Minimal)',
            'sharp' => '📐 Sharp / Square (0px - Modern Architectural)',
        ]);
    }

    public static function getImageShapeCss(?string $shape, ?string $fallback = 'rounded-xl'): string
    {
        if ($shape === 'inherit' || empty($shape)) {
            $shape = $fallback ?: 'rounded-xl';
        }

        return match ($shape) {
            'star', 'star-5' => 'border-radius: 0 !important; clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%) !important;',
            'star-8' => 'border-radius: 0 !important; clip-path: polygon(50% 0%, 65% 25%, 100% 50%, 75% 65%, 50% 100%, 25% 75%, 0% 50%, 25% 25%) !important;',
            'diamond' => 'border-radius: 0 !important; clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%) !important;',
            'hexagon' => 'border-radius: 0 !important; clip-path: polygon(25% 0%, 75% 0%, 100% 50%, 75% 100%, 25% 100%, 0% 50%) !important;',
            'octagon' => 'border-radius: 0 !important; clip-path: polygon(30% 0%, 70% 0%, 100% 30%, 100% 70%, 70% 100%, 30% 100%, 0% 70%, 0% 30%) !important;',
            'shield' => 'border-radius: 0 !important; clip-path: polygon(50% 0%, 100% 0%, 100% 75%, 50% 100%, 0% 75%, 0% 0%) !important;',
            'circle' => 'border-radius: 50% !important; clip-path: none !important;',
            'blob' => 'border-radius: 60% 40% 30% 70% / 60% 30% 70% 40% !important; clip-path: none !important;',
            'arch' => 'border-radius: 120px 120px 14px 14px !important; clip-path: none !important;',
            'arch-full' => 'border-radius: 9999px 9999px 14px 14px !important; clip-path: none !important;',
            'pill' => 'border-radius: 9999px !important; clip-path: none !important;',
            'squircle' => 'border-radius: 28% !important; clip-path: none !important;',
            'sharp' => 'border-radius: 0px !important; clip-path: none !important;',
            'rounded-sm' => 'border-radius: 4px !important; clip-path: none !important;',
            'rounded-md' => 'border-radius: 8px !important; clip-path: none !important;',
            'rounded-lg' => 'border-radius: 14px !important; clip-path: none !important;',
            'rounded-xl' => 'border-radius: 20px !important; clip-path: none !important;',
            'rounded-2xl' => 'border-radius: 28px !important; clip-path: none !important;',
            'rounded-3xl' => 'border-radius: 36px !important; clip-path: none !important;',
            default => 'border-radius: 20px !important; clip-path: none !important;',
        };
    }

    public static function getImageRadiusCss(?string $shape, ?string $fallback = 'rounded-xl'): array
    {
        if ($shape === 'inherit' || empty($shape)) {
            $shape = $fallback ?: 'rounded-xl';
        }

        return match ($shape) {
            'star', 'star-5' => ['border-radius' => '0px', 'clip-path' => 'polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%)'],
            'star-8' => ['border-radius' => '0px', 'clip-path' => 'polygon(50% 0%, 65% 25%, 100% 50%, 75% 65%, 50% 100%, 25% 75%, 0% 50%, 25% 25%)'],
            'diamond' => ['border-radius' => '0px', 'clip-path' => 'polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%)'],
            'hexagon' => ['border-radius' => '0px', 'clip-path' => 'polygon(25% 0%, 75% 0%, 100% 50%, 75% 100%, 25% 100%, 0% 50%)'],
            'octagon' => ['border-radius' => '0px', 'clip-path' => 'polygon(30% 0%, 70% 0%, 100% 30%, 100% 70%, 70% 100%, 30% 100%, 0% 70%, 0% 30%)'],
            'shield' => ['border-radius' => '0px', 'clip-path' => 'polygon(50% 0%, 100% 0%, 100% 75%, 50% 100%, 0% 75%, 0% 0%)'],
            'circle' => ['border-radius' => '50%', 'clip-path' => 'none'],
            'blob' => ['border-radius' => '60% 40% 30% 70% / 60% 30% 70% 40%', 'clip-path' => 'none'],
            'arch' => ['border-radius' => '120px 120px 14px 14px', 'clip-path' => 'none'],
            'arch-full' => ['border-radius' => '9999px 9999px 14px 14px', 'clip-path' => 'none'],
            'pill' => ['border-radius' => '9999px', 'clip-path' => 'none'],
            'squircle' => ['border-radius' => '28%', 'clip-path' => 'none'],
            'sharp' => ['border-radius' => '0px', 'clip-path' => 'none'],
            'rounded-sm' => ['border-radius' => '4px', 'clip-path' => 'none'],
            'rounded-md' => ['border-radius' => '8px', 'clip-path' => 'none'],
            'rounded-lg' => ['border-radius' => '14px', 'clip-path' => 'none'],
            'rounded-xl' => ['border-radius' => '20px', 'clip-path' => 'none'],
            'rounded-2xl' => ['border-radius' => '28px', 'clip-path' => 'none'],
            'rounded-3xl' => ['border-radius' => '36px', 'clip-path' => 'none'],
            default => ['border-radius' => '20px', 'clip-path' => 'none'],
        };
    }
}


