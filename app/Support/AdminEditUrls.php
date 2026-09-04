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
            'site-header', 'site-brand', 'site-company-name' => self::siteSettings('company-name'),
            'site-logo' => self::siteSettings('logo'),
            'site-tagline' => self::siteSettings('tagline'),
            'site-header-cta' => self::siteSettings('header-cta'),
            'site-nav', 'site-connect' => self::siteSettings('navigation'),
            'site-social' => self::siteSettings('social'),
            'site-contact' => self::siteSettings('contact'),
            'site-footer', 'site-footer-credit' => self::siteSettings('footer-display'),
            default => null,
        };
    }
}
