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
