@extends('layouts.app')

@section('content')
<!-- Page Content -->
<div class="page-content">

        <!-- Hero Features Section -->
        <x-hero-features :features="$heroFeatures" />

        <!-- About Section -->
        <x-about-section :features="$aboutFeatures" subtitle="Who We Are" title="Veritas Afrika Co.Ltd"
            description="Veritas Afrika Co.Ltd is a multi-disciplinary company of professional consultants specializing in a wide range of civil engineering works. We provide expert services to government, non-government, and private-sector customers."
            buttonText="Discover More" buttonUrl="#" />
        <!-- CTA Section -->
        <x-cta-section />

        <x-service-section :services="$services" />



        <!-- Video Section -->
        <x-video-section />

        <!-- Blog Section -->
        <x-blog-section />

    <!-- Hero Features Section -->
    <div class="mt-5 mb-5">
        <x-hero-features :features="$data['heroFeatures']?->list_items ?? []" />
    </div>

    <hr>

    <!-- About Section -->
    @if($data['aboutFeatures'])
    <x-about-section
        :features="$data['aboutFeatures']?->metadata ?? []"
        :slidePages="$data['aboutFeatures']?->list_items ?? []"
        image="{{ $data['aboutFeatureImageUrl'] }}"
        subtitle="{{ $data['aboutFeatures']?->subtitle ?? '' }}"
        title="{{ $data['aboutFeatures']?->title ?? '' }}"
        description="{{ $data['aboutFeatures']?->short_description ?? '' }}"
        buttonText="Discover More"
        buttonUrl="#" />
    @endif

    <!-- CTA Section -->
    <x-cta-section
        :content="$data['cta'] ?? []"
        :content2="$data['cta2'] ?? []"
         />

    <x-service-section />

    <!-- Video Section -->

    <x-video-section
        :videoUrl="$data['videoSection']['video_url'] ?? ''"
        :videoThumbnail="$data['videoThumbnail'] ?? ''"
        :thumbnailShortDescription="$data['videoDetails']['short_description'] ?? ''"
        subtitle="{{ $data['videoSection']['subtitle'] ?? '' }}"
        chartDescription="{{ $data['videoSection']['short_description'] ?? '' }}"
        industriesTitle="{{ $data['videoDetails']['list_items'][0]['title'] ?? '' }}"
        industriesDescription="{{ $data['videoDetails']['list_items'][0]['description'] ?? '' }}"
        :industries="array_values($data['videoDetails']['metadata'] ?? [])"
        locationsTitle="OUR LOCATION"
        mapUrl="{{ $data['map'] ?? '' }}"
    />

    <!-- Blog Section -->
    <x-blog-section
        title="Latest News & Articles"
        subtitle="Stay Updated"
        :posts="$blogPosts" /> 

</div>
<!-- Page Content End -->
@endsection
