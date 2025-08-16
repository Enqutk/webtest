<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Models\ContentBlock;
use App\Models\Organization;
use App\Models\OrganizationContact;
use Illuminate\Support\Facades\Cache;

class HomeContentService
{
    public function getHomeContent()
    {
        $orgId = Organization::first()?->id ?? 'default';

        return Cache::remember("home_content_data_{$orgId}", 3600, function () {
            $organization = Organization::select(['address', 'opening_hours', 'map_url'])->first();

            $contacts = OrganizationContact::where('status', StatusEnum::active)
                ->select(['type', 'value'])
                ->get()
                ->groupBy('type');

            $blocks = ContentBlock::where('is_active', true)
                ->whereIn('slug', [
                    'key-features',
                    'veritas-afrika-co-ltd',
                    'veritas-afrika-co-ltd-image',
                    'call-to-action-left',
                    'call-to-action-right',
                    'video-section',
                    'video-thumbnail',
                    'video-details',
                ])
                ->select(['id', 'slug', 'short_description', 'content', 'list_items', 'metadata'])
                ->with('media') // important to avoid N+1
                ->get()
                ->keyBy('slug');

            return [
                'email'   => $contacts->get('email', collect())->pluck('value')->all(),
                'phone'   => $contacts->get('phone', collect())->pluck('value')->all(),
                'fax'     => $contacts->get('fax', collect())->pluck('value')->all(),
                'address' => $organization->address ?? null,
                'working_days' => $organization->opening_hours ?? [],
                'map'     => $organization->map_url ?? null,

                'heroFeatures' => $blocks->get('key-features'),
                'aboutFeatures' => $blocks->get('veritas-afrika-co-ltd'),
                'aboutFeatureImageUrl' => $blocks->get('veritas-afrika-co-ltd-image')
                    ? $blocks->get('veritas-afrika-co-ltd-image')->getFirstMediaUrl('images')
                    : asset('assets/images/homepage-2/about-img-01.png'),

                'cta' => $blocks->get('call-to-action-left')
                    ? [
                        'short_description' => $blocks->get('call-to-action-left')->short_description,
                        'image' => $blocks->get('call-to-action-left')->getFirstMediaUrl('images'),
                    ]
                    : [
                        'short_description' => '',
                        'image' => asset('assets/images/default-cta-image.png'),
                    ],

                'cta2' => $blocks->get('call-to-action-right')
                    ? [
                        'short_description' => $blocks->get('call-to-action-right')->short_description,
                        'image' => $blocks->get('call-to-action-right')->getFirstMediaUrl('images'),
                    ]
                    : [
                        'short_description' => '',
                        'image' => asset('assets/images/default-cta-image.png'),
                    ],

                'cta2Content' => $blocks->get('call-to-action-right')->content ?? '',

                'videoSection' => $blocks->get('video-section')
                    ? $blocks->get('video-section')->getFirstMediaUrl('videos')
                    : 'https://www.youtube.com/watch?v=x36EQP2og-k',

                'videoThumbnail' => $blocks->get('video-thumbnail') 
                    ? $blocks->get('video-thumbnail')->getFirstMediaUrl('images')
                    : asset('assets/images/homepage-2/video-thumbnail.png'),

                'videoDetails' => $blocks->get('video-details') ? [
                    'short_description' => $blocks->get('video-details')->short_description,
                    'list_items' => $blocks->get('video-details')->list_items,
                    'metadata' => $blocks->get('video-details')->metadata,
                ] : null,
            ];
        });
    }
}
