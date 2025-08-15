@extends('layouts.inner')

@section('title', $service->title)
@section('page_title', $service->title)
@section('description', $service->short_description)

@section('content')
<!-- Service Detail Start -->
<section class="section-xxl fade-section py-5">
    <div class="container">
        <div class="row g-5">
              <div class="col-md-12 col-xl-3 service-left-col sidebar">
                    <aside class="service-sidebar">
                        <aside class="widget post-list">
                            <div class="all-post-list">
                                <ul>
                                    @foreach ($relatedServices as $item)
                                        <li class="{{ $item->id === $service->id ? 'post-active' : '' }}">
                                            <a href="{{ route('services.show', $item->slug) }}">
                                                {{ $item->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </aside>
                    </aside>
                </div>

            <!-- Main Content -->
            <div class="col-md-12 col-xl-9 service-right-col">
                <div class="pbmit-heading-subheading mb-4">
                    <h4 class="pbmit-subtitle text-muted">Service Detail</h4>
                    <h2 class="pbmit-title">{{ $service->title }}</h2>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        @if($service->secondary_image_url)
                            <img src="{{ $service->secondary_image_url }}"
                                 class="img-fluid rounded shadow-sm"
                                 alt="{{ $service->title }}">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center border"
                                 style="height: 300px;">
                                <i class="pbmit-induyst-icon pbmit-induyst-icon-water-drop"
                                   style="font-size: 4rem; color: #ccc;"></i>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <div class="pbmit-service-description mb-4">
                            <h5 class="fw-bold">Description</h5>
                            <p>{!! \Purifier::clean($service->description) !!}</p>
                        </div>

                        @if ($service->features)
                            <div class="pbmit-service-features mb-4">
                                <h5>Key Features</h5>
                                <ul class="list-unstyled">
                                    @foreach(json_decode($service->features) as $feature)
                                        <li class="mb-2 d-flex align-items-start">
                                            <i class="pbmit-induyst-icon pbmit-induyst-icon-check me-2 text-success"></i>
                                            <span>{{ $feature }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if ($service->quote)
                            <blockquote class="blockquote p-3 bg-light border-start border-primary border-4 rounded">
                                <p class="mb-0 fst-italic">"{{ $service->quote }}"</p>
                            </blockquote>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Service Detail End -->

<!-- Related Services Start -->
@if($relatedServices->count() > 0)
<section class="section-lg pbmit-bg-color-light py-5">
    <div class="container">
        <div class="pbmit-heading-subheading text-center mb-5">
            <h4 class="pbmit-subtitle text-muted">Other Services</h4>
            <h2 class="pbmit-title fw-bold">Related Services</h2>
        </div>

        <div class="row g-4">
            @foreach($relatedServices as $relatedService)
                <div class="col-md-6 col-lg-4">
                    <div class="service-card h-100 p-4 text-center bg-white rounded shadow-sm hover-shadow">
                        <div class="service-icon mb-3">
                            @if($relatedService->svg_inline)
                                {!! $relatedService->svg_inline !!}
                            @else
                                <i class="pbmit-induyst-icon pbmit-induyst-icon-water-drop fs-1 text-primary"></i>
                            @endif
                        </div>
                        <h3 class="service-title h5 fw-bold mb-2">{{ $relatedService->title }}</h3>
                        <p class="text-muted mb-3">
                            {{ \Illuminate\Support\Str::limit($relatedService->short_description, 100) }}
                        </p>
                        <a href="{{ route('services.show', $relatedService->slug) }}" class="btn btn-outline-primary btn-sm">
                            Learn More <i class="pbmit-induyst-icon pbmit-induyst-icon-next ms-1"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- Related Services End -->
@endsection
