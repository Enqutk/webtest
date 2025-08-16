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
    @php
    $features = collect($data['heroFeatures'])->pluck('list_items')->flatten(1)->all();
    @endphp
    <div class="mt-5 mb-5">
        <x-hero-features :data="$data" />
    </div>

    <hr>



    <!-- About Section -->
    @if(isset($data['aboutFeatures']) && count($data['aboutFeatures']) > 0)
    @foreach($data['aboutFeatures'] as $about)
    <x-about-section
        :features="$about['metadata'] ?? []"
        :slidePages="$about['list_items'] ?? []"
        image="{{ $data['aboutFeatureImageUrl'] }}"
        subtitle="{{ $about['subtitle'] ?? '' }}"
        title="{{ $about['title'] ?? '' }}"
        description="{{ $about['short_description'] ?? '' }}"
        buttonText="Discover More"
        buttonUrl="#" />
    @endforeach
    @endif
    <!-- CTA Section -->
    <x-cta-section
        :content="$data['cta'] ?? ''"
        :content2="$data['cta2'] ?? ''"
        contentValue=" $data['cta2Content']"
    />

    <x-service-section />



    <!-- Video Section -->
    <x-video-section :data="$data['videoSection']" :thumbnail="$data['videoThumbnail']" />

    <!-- Blog Section -->
    <x-blog-section
        title="Latest News & Articles"
        subtitle="Stay Updated"
        :posts="$blogPosts" />

</div>
<!-- Page Content End -->
@endsection