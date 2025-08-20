@extends('layouts.app')

@section('content')
<!-- Page Content -->
<div class="page-content mb-4">
    {{-- <!-- Hero Features Section -->
    <div class="mt-5 mb-5">
        <x-hero-features :features="$data['heroFeatures']?->list_items ?? []" />
    </div> --}}

    {{-- <hr> --}}

    <!-- About Section -->
    @if($data['aboutFeatures'])
    <x-about-section
        :image="$data['aboutFeatures']['image']"
        :subtitle="$data['aboutFeatures']['subtitle']"
        :title="$data['aboutFeatures']['title']"
        :description="$data['aboutFeatures']['description']" />
    @endif

    <x-service-section :services="$services" />

    <!-- Video Section -->

    <x-video-section
        :videoUrl="$data['videoSection']['video_url'] ?? ''"
        subtitle="{{ $data['videoSection']['subtitle'] ?? '' }}"
        :videoThumbnail="$data['videoThumbnail'] ?? ''"
        :thumbnailShortDescription="$data['videoDetails']['short_description'] ?? ''"
        chartDescription="{{ $data['videoSection']['short_description'] ?? '' }}"
        industriesTitle="{{ $data['videoDetails']['list_items'][0]['title'] ?? '' }}"
        industriesDescription="{{ $data['videoDetails']['list_items'][0]['description'] ?? '' }}"
        :industries="array_values($data['videoDetails']['metadata'] ?? [])"
        locationsTitle="OUR LOCATION"
        mapUrl="{{ $data['map'] ?? '' }}" />
</div>
<!-- Page Content End -->
@endsection