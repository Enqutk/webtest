<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Models\ContentBlock;
use App\Models\Organization;
use App\Models\OrganizationContact;

class HomeContentService
{
    public function getHomeContent(): array
    {
        $organization = Organization::select(['address', 'opening_hours', 'map_url'])->first();

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

        return [
            'email' => $contacts->get('email', collect())->pluck('value')->all(),
            'phone' => $contacts->get('phone', collect())->pluck('value')->all(),
            'fax' => $contacts->get('fax', collect())->pluck('value')->all(),
            'address' => $organization->address ?? null,
            'working_days' => $organization->opening_hours ?? [],
            'map' => $organization->map_url ?? null,

            'heroFeatures' => $blocks->get('key-features'),
            'aboutFeatures' => $aboutFeaturesBlock
                ? [
                    'image' => $aboutFeaturesBlock->getFirstMediaUrl('images') ?: asset('assets/images/homepage-2/about-img-01.png'),
                    'title' => $aboutFeaturesBlock->title,
                    'subtitle' => $aboutFeaturesBlock->subtitle,
                    'description' => html_entity_decode((string) $aboutFeaturesBlock->content),
                ]
                : null,

            'aboutSection1' => $aboutSection1Block
                ? [
                    'image' => $aboutSection1Block->getFirstMediaUrl('images') ?: asset('assets/images/homepage-2/about-img-01.png'),
                    'description' => html_entity_decode((string) $aboutSection1Block->content),
                ]
                : null,

            'aboutSection2' => $aboutSection2Block
                ? [
                    'image' => $aboutSection2Block->getFirstMediaUrl('images') ?: asset('assets/images/banner-slider-img/slider3-04.jpg'),
                    'description' => html_entity_decode((string) $aboutSection2Block->content),
                ]
                : null,

            'videoSection' => $blocks->get('video-section'),

            'videoThumbnail' => $blocks->get('video-thumbnail')
                ? $blocks->get('video-thumbnail')->getFirstMediaUrl('images')
                : asset('assets/images/homepage-2/video-thumbnail.png'),

            'videoDetails' => $blocks->get('video-details') ? [
                'short_description' => $blocks->get('video-details')->short_description,
                'list_items' => $blocks->get('video-details')->list_items,
                'metadata' => $blocks->get('video-details')->metadata,
            ] : null,

            'stats' => $statsBlock?->list_items ?? [],
            'statsTitle' => $statsBlock?->title ?: 'Impact that compounds',
            'statsSubtitle' => $statsBlock?->subtitle ?: 'By the numbers',
        ];
    }
}
