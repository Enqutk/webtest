@extends('layouts.app')

@section('content')
<!-- Page Content -->
<div class="page-content">

    @php

    $blogPosts = [
    [
    'title' => 'The Role of Energy Storage in the Transition to Renewables',
    'excerpt' => 'When evaluating a single group or company, its dominant source of revenue is typically used&hellip;',
    'image' => './assets/images/homepage-2/blog/blog-img-01.jpg',
    'url' => 'blog-single-details.html',
    'date' => '06',
    'month' => 'Feb',
    'author' => 'Alex joy',
    'category' => 'Chemical',
    'categoryUrl' => 'blog-classic.html',
    'comments' => '3'
    ],
    [
    'title' => 'Automation & Human-Robot Collab: The New Workforce',
    'excerpt' => 'When evaluating a single group or company, its dominant source of revenue is typically used&hellip;',
    'image' => './assets/images/homepage-2/blog/blog-img-06.jpg',
    'url' => 'blog-single-details.html',
    'date' => '06',
    'month' => 'Feb',
    'author' => 'Alex joy',
    'category' => 'Engineering',
    'categoryUrl' => 'blog-classic.html',
    'comments' => '3'
    ]
    ];
    @endphp

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
        :contentValue="$data['cta2Content'] ?? ''" />

    <x-service-section />

    <!-- Video Section -->

    <x-video-section
        :videoUrl="$data['videoSection'] ?? ''"
        :videoThumbnail="$data['videoThumbnail'] ?? ''"
        :thumbnailShortDescription="$data['videoDetails']['short_description'] ?? ''"
        subtitle="Working Process"
        chartDescription="{{ $data['videoThumbnail']['metadata']['Working Process'] ?? '' }}"
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