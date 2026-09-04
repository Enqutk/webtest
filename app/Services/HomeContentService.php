<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Models\ContentBlock;
use App\Models\Organization;
use App\Models\OrganizationContact;
use Illuminate\Support\Str;

class HomeContentService
{
    public function getHomeContent(): array
    {
        $organization = Organization::resolvePublicCurrent();
        $organization->loadMissing('media');

        $contacts = OrganizationContact::where('organization_id', $organization->id)
            ->where('status', StatusEnum::active)
            ->select(['type', 'value'])
            ->get()
            ->groupBy('type');

        $blocks = ContentBlock::where('organization_id', $organization->id)
            ->where('is_active', true)
            ->whereIn('slug', [
                'key-features',
                'veritas-afrika-co-ltd',
                'about-section-1',
                'about-section-2',
                'video-section',
                'video-thumbnail',
                'video-details',
                'stats',
            ])
            ->select(['id', 'slug', 'short_description', 'content', 'list_items', 'metadata', 'title', 'subtitle', 'icon', 'video_url'])
            ->with('media')
            ->get()
            ->keyBy('slug');

        $aboutFeaturesBlock = $blocks->get('veritas-afrika-co-ltd');
        $aboutSection1Block = $blocks->get('about-section-1');
        $aboutSection2Block = $blocks->get('about-section-2');
        $statsBlock = $blocks->get('stats');

        $siteName = $organization?->title ?: config('app.name', 'Site');

        if ($organization?->tagline) {
            $tagline = $organization->tagline;
        } elseif ($aboutFeaturesBlock?->short_description) {
            $tagline = $aboutFeaturesBlock->short_description;
        } else {
            $tagline = Str::limit(trim(strip_tags((string) ($aboutFeaturesBlock?->content ?? ''))), 160) ?: '';
        }

        $metaDescription = $organization?->meta_description
            ?: ($tagline !== '' ? "{$siteName} — {$tagline}" : $siteName);

        $theme = $organization
            ? $organization->resolvedTheme()
            : array_merge(Organization::defaultTheme(), [
                'accent_soft' => Organization::hexToRgba(Organization::defaultTheme()['accent'], 0.12),
            ]);
        $sitePages = $organization
            ? [
                'about' => $organization->sitePage('about'),
                'contact' => $organization->sitePage('contact'),
                'services' => $organization->sitePage('services'),
                'portfolio' => $organization->sitePage('portfolio'),
            ]
            : Organization::defaultSitePages();

        $aboutImage = $aboutFeaturesBlock?->getFirstMediaUrl('images') ?: null;

        $logoUrl = ($theme['show_logo'] ?? true) ? $organization?->logo_url : null;
        $faviconUrl = ($theme['show_favicon'] ?? true) ? $organization?->favicon_url : null;
        $activeTagline = ($theme['show_tagline'] ?? true) ? $tagline : '';
        $activeAddress = ($theme['show_address'] ?? true) ? ($organization->address ?? null) : null;
        $activeWorkingDays = ($theme['show_opening_hours'] ?? true) ? ($organization->opening_hours ?? []) : [];
        $activeMap = ($theme['show_map'] ?? true) ? ($organization->map_url ?? null) : null;
        $activeEmail = ($theme['show_email'] ?? true) ? $contacts->get('email', collect())->pluck('value')->all() : [];
        $activePhone = ($theme['show_phone'] ?? true) ? $contacts->get('phone', collect())->pluck('value')->all() : [];

        $defaultSections = Organization::defaultHomeSections();
        $configuredSections = $theme['home_sections'] ?? [];
        $homeSections = array_replace_recursive($defaultSections, is_array($configuredSections) ? $configuredSections : []);

        // Repeater arrays must take exact user configuration
        if (isset($configuredSections['hero']['slides']) && is_array($configuredSections['hero']['slides'])) {
            $homeSections['hero']['slides'] = $configuredSections['hero']['slides'];
        }
        if (isset($configuredSections['stats']['items']) && is_array($configuredSections['stats']['items'])) {
            $homeSections['stats']['items'] = $configuredSections['stats']['items'];
        }
        if (isset($configuredSections['about']['points']) && is_array($configuredSections['about']['points'])) {
            $homeSections['about']['points'] = $configuredSections['about']['points'];
        }

        $statsItems = !empty($homeSections['stats']['items'])
            ? $homeSections['stats']['items']
            : ($statsBlock?->list_items ?? []);

        $routeSlug = request()->route('slug') ?? ($organization?->slug ?: null);

        $brandHomeUrl = $routeSlug
            ? route('card.home', ['slug' => $routeSlug])
            : ($organization ? route('card.home', ['slug' => $organization->slug ?: \Illuminate\Support\Str::slug($organization->title) ?: 'default']) : url('/'));

        $contactUrl = $routeSlug
            ? route('card.contact', ['slug' => $routeSlug])
            : ($organization ? route('card.contact', ['slug' => $organization->slug]) : route('contact'));

        $aboutUrl = $routeSlug
            ? route('card.about', ['slug' => $routeSlug])
            : ($organization ? route('card.about', ['slug' => $organization->slug]) : route('about'));

        $servicesUrl = $routeSlug
            ? route('card.services.index', ['slug' => $routeSlug])
            : ($organization ? route('card.services.index', ['slug' => $organization->slug]) : route('services.index'));

        $portfolioUrl = $routeSlug
            ? route('card.portfolio.index', ['slug' => $routeSlug])
            : ($organization ? route('card.portfolio.index', ['slug' => $organization->slug]) : route('portfolio.index'));

        return [
            'organization' => $organization,
            'brandHomeUrl' => $brandHomeUrl,
            'contactUrl' => $contactUrl,
            'aboutUrl' => $aboutUrl,
            'servicesUrl' => $servicesUrl,
            'portfolioUrl' => $portfolioUrl,
            'routeSlug' => $routeSlug,
            'siteName' => $siteName,
            'tagline' => $activeTagline,
            'metaDescription' => $metaDescription,
            'theme' => $theme,
            'sitePages' => $sitePages,
            'homeSections' => $homeSections,
            'logoUrl' => $logoUrl,
            'faviconUrl' => $faviconUrl,

            'email' => $activeEmail,
            'phone' => $activePhone,
            'fax' => $contacts->get('fax', collect())->pluck('value')->all(),
            'address' => $activeAddress,
            'po_box' => ($theme['show_po_box'] ?? true) ? ($organization->po_box ?? null) : null,
            'working_days' => $activeWorkingDays,
            'map' => $activeMap,

            'heroFeatures' => $blocks->get('key-features'),
            'aboutFeatures' => [
                'image' => Organization::themeFileUrl($sitePages['about']['intro']['image'] ?? null) ?: $aboutImage,
                'title' => $sitePages['about']['intro']['title']
                    ?? $homeSections['about']['title']
                    ?? ($aboutFeaturesBlock?->title ?: 'Water expertise for living landscapes'),
                'subtitle' => $sitePages['about']['intro']['eyebrow']
                    ?? $homeSections['about']['eyebrow']
                    ?? ($aboutFeaturesBlock?->subtitle ?: 'Who we are'),
                'description' => (function () use ($sitePages, $homeSections, $aboutFeaturesBlock) {
                    if (!empty($sitePages['about']['intro']['description'])) {
                        return nl2br(e($sitePages['about']['intro']['description']));
                    }
                    $about = $homeSections['about'] ?? [];
                    $copy = $about['description']
                        ?? trim(collect([
                            $about['paragraph_1'] ?? null,
                            $about['paragraph_2'] ?? null,
                        ])->filter()->implode("\n\n"));
                    if ($copy !== '') {
                        return nl2br(e($copy));
                    }
                    return $aboutFeaturesBlock
                        ? html_entity_decode((string) $aboutFeaturesBlock->content)
                        : '';
                })(),
                'points' => $sitePages['about']['intro']['points']
                    ?? $homeSections['about']['points']
                    ?? [],
            ],

            'aboutSection1' => !empty($sitePages['about']['story']['panels'][0] ?? null)
                ? [
                    'image' => Organization::themeFileUrl($sitePages['about']['story']['panels'][0]['image'] ?? null),
                    'title' => $sitePages['about']['story']['panels'][0]['title'] ?? null,
                    'subtitle' => $sitePages['about']['story']['eyebrow'] ?? null,
                    'description' => nl2br(e((string) ($sitePages['about']['story']['panels'][0]['description'] ?? ''))),
                ]
                : ($aboutSection1Block
                ? [
                    'image' => $aboutSection1Block->getFirstMediaUrl('images') ?: null,
                    'title' => $aboutSection1Block->title,
                    'subtitle' => $aboutSection1Block->subtitle,
                    'description' => html_entity_decode((string) $aboutSection1Block->content),
                ]
                : null),

            'aboutSection2' => !empty($sitePages['about']['story']['panels'][1] ?? null)
                ? [
                    'image' => Organization::themeFileUrl($sitePages['about']['story']['panels'][1]['image'] ?? null),
                    'title' => $sitePages['about']['story']['panels'][1]['title'] ?? null,
                    'subtitle' => $sitePages['about']['story']['eyebrow'] ?? null,
                    'description' => nl2br(e((string) ($sitePages['about']['story']['panels'][1]['description'] ?? ''))),
                ]
                : ($aboutSection2Block
                ? [
                    'image' => $aboutSection2Block->getFirstMediaUrl('images') ?: null,
                    'title' => $aboutSection2Block->title,
                    'subtitle' => $aboutSection2Block->subtitle,
                    'description' => html_entity_decode((string) $aboutSection2Block->content),
                ]
                : null),

            'videoSection' => $blocks->get('video-section'),

            'videoThumbnail' => $blocks->get('video-thumbnail')
                ? ($blocks->get('video-thumbnail')->getFirstMediaUrl('images') ?: null)
                : null,

            'videoDetails' => $blocks->get('video-details') ? [
                'short_description' => $blocks->get('video-details')->short_description,
                'list_items' => $blocks->get('video-details')->list_items,
                'metadata' => $blocks->get('video-details')->metadata,
            ] : null,

            'stats' => $statsItems,
            'statsTitle' => $homeSections['stats']['title'] ?? ($statsBlock?->title ?: 'Impact that compounds'),
            'statsSubtitle' => $homeSections['stats']['eyebrow'] ?? ($statsBlock?->subtitle ?: 'By the numbers'),
        ];
    }
}
