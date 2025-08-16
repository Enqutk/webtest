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
        return Cache::remember('home_content_data', 3600, function () {
            $organization = Organization::first();
            $contacts = OrganizationContact::where('status', StatusEnum::active)->get()->groupBy('type');

            // Fetch all needed blocks in one query
            $blocks = ContentBlock::where('is_active', true)
                ->whereIn('slug', [
                    'key-features',
                    'veritas-afrika-co-ltd',
                    'veritas-afrika-co-ltd-image',
                    'call-to-action-left',
                    'call-to-action-right',
                    'video-section',
                    'video-thumbnail'
                ])
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

                'cta' => $blocks->get('call-to-action-left')->short_description ?? '',
                'cta2' => $blocks->get('call-to-action-right')->short_description ?? '',
                'cta2Content' => $blocks->get('call-to-action-right')->content ?? '',

                'videoSection' => $blocks->get('video-section') ? [
                    'short_description' => $blocks->get('video-section')->short_description,
                    'metadata' => $blocks->get('video-section')->metadata,
                    'videos' => $blocks->get('video-section')->video_urls,
                ] : null,

                'videoThumbnail' => $blocks->get('video-thumbnail') ? [
                    'short_description' => $blocks->get('video-thumbnail')->short_description,
                    'metadata' => $blocks->get('video-thumbnail')->metadata,
                    'images' => $blocks->get('video-thumbnail')->image_urls,
                ] : null,
            ];
        });
    }
}
