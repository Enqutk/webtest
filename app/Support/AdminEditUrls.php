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
            'site-header', 'site-brand' => self::siteSettings('company-name'),
            'site-header-cta' => self::siteSettings('header-cta'),
            'site-nav' => self::siteSettings('navigation'),
            'site-social' => self::siteSettings('social'),
            'site-contact' => self::siteSettings('contact'),
            'site-footer' => self::siteSettings('footer-display'),
            default => null,
        };
    }
}
