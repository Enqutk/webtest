@extends('layouts.inner')

@section('title', $service->title)
@section('eyebrow', 'Service detail')
@section('page_title', $service->title)
@section('description', $service->short_description)

@section('page')
<section class="hz-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3">
                <nav class="hz-side-nav">
                    @foreach ($relatedServices as $item)
                        <a href="{{ route('services.show', $item->slug) }}" class="{{ $item->id === $service->id ? 'active' : '' }}">
                            {{ $item->title }}
                        </a>
                    @endforeach
                    <a href="{{ route('services.index') }}">All services</a>
                </nav>
            </div>
            <div class="col-lg-9">
                @if ($service->secondary_image_url || $service->main_image_url)
                    <img
                        src="{{ $service->secondary_image_url ?: $service->main_image_url }}"
                        class="w-100 border border-hz mb-4"
                        alt="{{ $service->title }}"
                    >
                @endif

                <div class="mb-4">
                    <h2 class="h4 mb-3">Description</h2>
                    <div>{!! \Purifier::clean($service->description) !!}</div>
                </div>

                @if ($service->features)
                    <div class="mb-4">
                        <h2 class="h4 mb-3">Key features</h2>
                        <div>{!! \Purifier::clean($service->features) !!}</div>
                    </div>
                @endif

                @if ($service->quote)
                    <blockquote class="hz-quote">{{ $service->quote }}</blockquote>
                @endif
            </div>
        </div>
    </div>
</section>

<x-horizon.cta />
@endsection
