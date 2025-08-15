@extends('layouts.app')

@section('content')
    <!-- Page Content -->
    <div class="page-content">

        @php


        $aboutFeatures = [
            'Professionalism',
            'Client-Centric Approach',
            'Regional Impact'
        ];

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
            <x-hero-features :data="$data" />
        </div>

        <hr>

        

        <!-- About Section -->
        <x-about-section 
            :features="$aboutFeatures"
            subtitle="Who We Are"
            title="Veritas Afrika Co.Ltd"
            description="Veritas Afrika Co.Ltd is a multi-disciplinary company of professional consultants specializing in a wide range of civil engineering works. We provide expert services to government, non-government, and private-sector customers."
            buttonText="Discover More"
            buttonUrl="#"
        />
        <!-- CTA Section -->
        <x-cta-section />
        
        <x-service-section />

    

        <!-- Video Section -->
        <x-video-section />

        <!-- Blog Section -->
        <x-blog-section 
            title="Latest News & Articles"
            subtitle="Stay Updated"
            :posts="$blogPosts"
        />

    </div>
    <!-- Page Content End -->
@endsection

