<?php

namespace App\Support;

class AdminEditUrls
{
    public static function siteSettings(?string $tab = null): string
    {
        $url = route('admin.site-settings.index');

        return $tab ? $url . '#' . $tab : $url;
    }

    public static function forCommonSection(string $section): ?string
    {
        return match ($section) {
            'site-header', 'site-brand', 'site-header-cta' => self::siteSettings('header'),
            'site-nav' => self::siteSettings('navigation'),
            'site-footer', 'site-social', 'site-contact' => self::siteSettings('footer'),
            default => null,
        };
    }
}
