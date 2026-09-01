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
        $organization = Organization::query()->with('media')->first();

        $contacts = OrganizationContact::where('status', StatusEnum::active)
            ->select(['type', 'value'])
            ->get()
            ->groupBy('type');

        $blocks = ContentBlock::where('is_active', true)
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

        $statsItems = !empty($homeSections['stats']['items'])
            ? $homeSections['stats']['items']
            : ($statsBlock?->list_items ?? []);

        return [
            'siteName' => $siteName,
            'tagline' => $activeTagline,
            'metaDescription' => $metaDescription,
            'theme' => $theme,
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
                'image' => $aboutImage,
                'title' => $homeSections['about']['title'] ?? ($aboutFeaturesBlock?->title ?: 'Water expertise for living landscapes'),
                'subtitle' => $homeSections['about']['eyebrow'] ?? ($aboutFeaturesBlock?->subtitle ?: 'Who we are'),
                'description' => !empty($homeSections['about']['description'])
                    ? nl2br(e($homeSections['about']['description']))
                    : ($aboutFeaturesBlock ? html_entity_decode((string) $aboutFeaturesBlock->content) : ''),
                'points' => $homeSections['about']['points'] ?? [],
            ],

            'aboutSection1' => $aboutSection1Block
                ? [
                    'image' => $aboutSection1Block->getFirstMediaUrl('images') ?: null,
                    'title' => $aboutSection1Block->title,
                    'subtitle' => $aboutSection1Block->subtitle,
                    'description' => html_entity_decode((string) $aboutSection1Block->content),
                ]
                : null,

            'aboutSection2' => $aboutSection2Block
                ? [
                    'image' => $aboutSection2Block->getFirstMediaUrl('images') ?: null,
                    'title' => $aboutSection2Block->title,
                    'subtitle' => $aboutSection2Block->subtitle,
                    'description' => html_entity_decode((string) $aboutSection2Block->content),
                ]
                : null,

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
