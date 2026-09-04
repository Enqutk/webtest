<?php

namespace App\Support;

class AdminEditUrls
{
    /** @var list<string> */
    public const HOME_SECTIONS = [
        'hero',
        'about',
        'services',
        'stats',
        'portfolio',
        'team',
        'clients',
        'cta',
    ];

    public static function siteSettings(?string $tab = null): string
    {
        $url = route('admin.site-settings.index');

        return $tab ? $url . '#' . $tab : $url;
    }

    public static function homeSections(?string $section = null, ?string $field = null): string
    {
        $url = route('admin.home-sections.index');

        if ($section) {
            $url .= '#admin-form-' . $section;
        }

        if ($field) {
            $url .= (str_contains($url, '?') ? '&' : '?') . 'field=' . urlencode($field);
        }

        return $url;
    }

    public static function sitePages(string $page, ?string $anchor = null): string
    {
        $url = route('admin.site-pages.edit', $page);

        return $anchor ? $url . '#' . ltrim($anchor, '#') : $url;
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

    public static function resolveSectionClick(string $section, ?string $field = null, ?string $editUrl = null): ?string
    {
        if ($editUrl) {
            return $editUrl;
        }

        if ($url = self::forCommonSection($section)) {
            return $url;
        }

        if (in_array($section, self::HOME_SECTIONS, true)) {
            return self::homeSections($section, $field);
        }

        return null;
    }

    /** @return array<string, string> */
    public static function editTargetsForJs(): array
    {
        $targets = [
            'site-header' => self::siteSettings('company-name'),
            'site-brand' => self::siteSettings('company-name'),
            'site-company-name' => self::siteSettings('company-name'),
            'site-logo' => self::siteSettings('logo'),
            'site-tagline' => self::siteSettings('tagline'),
            'site-nav' => self::siteSettings('navigation'),
            'site-connect' => self::siteSettings('navigation'),
            'site-header-cta' => self::siteSettings('header-cta'),
            'site-footer' => self::siteSettings('footer-display'),
            'site-footer-credit' => self::siteSettings('footer-display'),
            'site-social' => self::siteSettings('social'),
            'site-contact' => self::siteSettings('contact'),
            'page-hero' => self::currentPageHeroUrl(),
        ];

        foreach (self::HOME_SECTIONS as $section) {
            $targets[$section] = self::homeSections($section);
        }

        $targets['about-page-intro'] = self::sitePages('about', 'about-page-intro');
        $targets['about-page-story'] = self::sitePages('about', 'about-page-story');

        return array_filter($targets);
    }

    /** Site-settings hash anchors when already on that page (avoid full reload). */
    /** @return array<string, array{tab?: string, hash: string}> */
    public static function siteSettingsLocalAnchors(): array
    {
        return [
            'site-header' => ['tab' => 'header', 'hash' => 'company-name'],
            'site-brand' => ['tab' => 'header', 'hash' => 'company-name'],
            'site-company-name' => ['tab' => 'header', 'hash' => 'company-name'],
            'site-logo' => ['tab' => 'header', 'hash' => 'logo'],
            'site-tagline' => ['tab' => 'header', 'hash' => 'tagline'],
            'site-header-cta' => ['tab' => 'header', 'hash' => 'header-cta'],
            'site-nav' => ['tab' => 'navigation', 'hash' => 'navigation'],
            'site-connect' => ['tab' => 'navigation', 'hash' => 'navigation'],
            'site-social' => ['tab' => 'footer', 'hash' => 'social'],
            'site-contact' => ['tab' => 'footer', 'hash' => 'contact'],
            'site-footer' => ['tab' => 'footer', 'hash' => 'footer-display'],
            'site-footer-credit' => ['tab' => 'footer', 'hash' => 'footer-display'],
        ];
    }

    private static function currentPageHeroUrl(): ?string
    {
        $route = request()->route()?->getName();

        return match ($route) {
            'admin.site-pages.edit' => route('admin.site-pages.edit', request()->route('page')) . '#page-header',
            'admin.services.index' => route('admin.services.index') . '#page-header',
            'admin.portfolio.index' => route('admin.portfolio.index') . '#page-header',
            default => null,
        };
    }
}
