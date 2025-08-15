@extends('layouts.app')

@section('content')
    <!-- Page Content -->
    <div class="page-content">

        @php
        // Blog posts can be made dynamic similarly if needed, but About Section is now fully dynamic from DB
        @endphp

        <!-- Hero Features Section -->
        <div class="mt-5 mb-5">
            <x-hero-features :data="$data" />
        </div>

        <hr>

        

        <!-- About Section -->
        @if(isset($data['aboutFeatures']) && count($data['aboutFeatures']) > 0)
            @foreach($data['aboutFeatures'] as $about)
                <x-about-section 
                    :features="$about['list_items'] ?? []"
                    subtitle="{{ $about['subtitle'] ?? 'Who We Are' }}"
                    title="{{ $about['title'] ?? 'Veritas Afrika Co.Ltd' }}"
                    description="{{ $about['short_description'] ?? 'Veritas Afrika Co.Ltd is a multi-disciplinary company of professional consultants specializing in a wide range of civil engineering works. We provide expert services to government, non-government, and private-sector customers.' }}"
                    buttonText="{{ $about['button_text'] ?? 'Discover More' }}"
                    buttonUrl="{{ $about['button_url'] ?? '#' }}"
                />
            @endforeach
        @endif
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

