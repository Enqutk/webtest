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
        return Cache::remember('home_content_data', 60 * 60, function () {
            $organization = Organization::first();
            $address = $organization->address ?? null;
            $working_days = $organization->opening_hours ?? [];
            $map = $organization->map_url ?? null;

            $contactsByType = OrganizationContact::where('status', StatusEnum::active)
                ->get()
                ->groupBy('type');
            $email = $contactsByType->get('email', collect())->pluck('value')->all();
            $phone = $contactsByType->get('phone', collect())->pluck('value')->all();
            $fax = $contactsByType->get('fax', collect())->pluck('value')->all();

            $heroFeatures = ContentBlock::where('is_active', true)
                ->where('title', 'Key Features') // Replace with slug for stability
                ->where('display_order', 1)
                ->get()
                ->map(function ($block) {
                    $block->list_items = is_array($block->list_items)
                        ? $block->list_items
                        : json_decode($block->list_items, true);
                    return $block;
                });

            $aboutFeatures = ContentBlock::where('is_active', true)
                ->where('title', 'Veritas Afrika Co.Ltd') // Replace with slug for stability
                ->where('display_order', 2)
                ->get()
                ->map(function ($block) {
                    $block->list_items = is_array($block->list_items)
                        ? $block->list_items
                        : json_decode($block->list_items, true);
                    $block->metadata = is_array($block->metadata)
                        ? $block->metadata
                        : json_decode($block->metadata, true);
                    return [
                        'title' => $block->title,
                        'subtitle' => $block->subtitle,
                        'short_description' => $block->short_description,
                        'list_items' => $block->list_items,
                        'metadata' => $block->metadata,
                    ];
                });

            $aboutFeatureImageBlock = ContentBlock::where('is_active', true)
                ->where('title', 'Veritas Afrika Co.Ltd') 
                ->where('display_order', 3)
                ->first();

            $aboutFeatureImageUrl = $aboutFeatureImageBlock
                ? $aboutFeatureImageBlock->getFirstMediaUrl('images')
                : asset('assets/images/homepage-2/about-img-01.png');

            $ctaSection = ContentBlock::where('is_active', true)
                ->where('title', 'Call to Action') 
                ->where('display_order', 4)
                ->first();
            $ctaSection2 = ContentBlock::where('is_active', true)
                ->where('title', 'Call to Action') 
                ->where('display_order', 5)
                ->first();

            $cta = $ctaSection ? $ctaSection->short_description : '';
            $cta2 = $ctaSection2 ? $ctaSection2->short_description : '';
            $cta2Content = $ctaSection2 ? $ctaSection2->content : '';

            // Fetch Video Section content block
            $videoSection = ContentBlock::where('is_active', true)
                ->where('title', 'Video Section') 
                ->where('display_order', 6)
                ->first();

            if ($videoSection) {
                $videoSection->metadata = is_array($videoSection->metadata)
                    ? $videoSection->metadata
                    : json_decode($videoSection->metadata, true);
                $videoSectionData = [
                    'short_description' => $videoSection->short_description,
                    'metadata' => $videoSection->metadata,
                ];
            } else {
                $videoSectionData = null;
            }

            // Fetch Video Thumbnail content block for Video section
            $videoThumbnailSection = ContentBlock::where('is_active', true)
                ->where('title', 'Video Thumbnail')
                ->where('display_order', 7)
                ->first();

            if ($videoThumbnailSection) {
                $videoThumbnailSection->metadata = is_array($videoThumbnailSection->metadata)
                    ? $videoThumbnailSection->metadata
                    : json_decode($videoThumbnailSection->metadata, true);
                $videoThumbnailData = [
                    'short_description' => $videoThumbnailSection->short_description,
                    'metadata' => $videoThumbnailSection->metadata,
                ];
            } else {
                $videoThumbnailData = null;
            }

            return array_merge(
                ['email' => $email, 'phone' => $phone, 'fax' => $fax],
                ['address' => $address, 'working_days' => $working_days, 'map' => $map],
                ['heroFeatures' => $heroFeatures, 'aboutFeatures' => $aboutFeatures, 'aboutFeatureImageUrl' => $aboutFeatureImageUrl],
                ['cta' => $cta, 'cta2' => $cta2, 'cta2Content' => $cta2Content],
                ['videoSection' => $videoSectionData, 'videoThumbnail' => $videoThumbnailData]
            );
        });
    }
}
