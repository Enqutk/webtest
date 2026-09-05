@extends('layouts.inner')

@php
    $servicesPage = $data['sitePages']['services'] ?? [];
    $isGallery = ($servicesPage['layout'] ?? null) === 'gallery';
    $routeSlug = $data['routeSlug'] ?? request()->route('slug');
    $indexUrl = $data['servicesUrl'] ?? route('services.index');
    $contactUrl = $data['contactUrl'] ?? route('contact');
    $itemUrl = function ($slug) use ($routeSlug) {
        return $routeSlug
            ? route('card.services.show', ['slug' => $routeSlug, 'service_slug' => $slug])
            : route('services.show', $slug);
    };
@endphp

@section('title', $service->title)
@section('eyebrow', $isGallery ? 'Gallery piece' : 'Service detail')
@section('page_title', $service->title)
@section('description', $service->short_description)

@php
    $heroImage = $service->secondary_image_url ?: $service->main_image_url;
@endphp

@section('page')
<section class="hz-section hz-service-detail">
    <div class="container">
        <div class="row g-4 g-xl-5">
            <div class="col-lg-3">
                <aside class="hz-side-nav hz-service-nav">
                    <p class="hz-side-nav-label">{{ $isGallery ? 'Gallery' : 'Services' }}</p>
                    @foreach ($allServices as $item)
                        <a
                            href="{{ $itemUrl($item->slug) }}"
                            class="{{ $item->id === $service->id ? 'active' : '' }}"
                            @if($item->id === $service->id) aria-current="page" @endif
                        >
                            {{ $item->title }}
                        </a>
                    @endforeach
                    <a href="{{ $indexUrl }}" class="hz-side-nav-all">
                        {{ $isGallery ? 'Back to gallery' : 'View all services' }} <i class="bi bi-arrow-right"></i>
                    </a>
                </aside>
            </div>

            <div class="col-lg-9">
                @if($heroImage)
                    <div class="hz-service-hero mb-4">
                        <img src="{{ $heroImage }}" alt="{{ $service->title }}">
                    </div>
                @endif

                @if($service->short_description)
                    <p class="hz-lead mb-4">{{ $service->short_description }}</p>
                @endif

                @if($service->description)
                    <div class="hz-prose mb-4">
                        <h2 class="h4 mb-3">Overview</h2>
                        {!! \Purifier::clean($service->description) !!}
                    </div>
                @endif

                @if($service->features)
                    <div class="hz-service-features mb-4">
                        <h2 class="h4 mb-3">{{ $isGallery ? 'In this piece' : 'Key features' }}</h2>
                        <div class="hz-prose">
                            {!! \Purifier::clean($service->features) !!}
                        </div>
                    </div>
                @endif

                @if($service->quote)
                    <blockquote class="hz-quote mb-4">{{ $service->quote }}</blockquote>
                @endif

                <div class="d-flex flex-wrap gap-3 mt-4">
                    <a href="{{ $contactUrl }}" class="btn-hz">
                        {{ $isGallery ? 'Talk to me about this' : 'Discuss this service' }} <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="{{ $indexUrl }}" class="btn-hz-outline">{{ $isGallery ? 'Back to gallery' : 'Back to services' }}</a>
                </div>
            </div>
        </div>
    </div>
</section>

<x-horizon.cta />
@endsection
