@extends('layouts.inner')

@section('title', $service->title)
@section('page_title', $service->title)
@section('description', $service->short_description)

@section('content')
<!-- Service Detail Start -->
<section class="section-xxl fade-section">
    <div class="container">
        <div class="pbmit-heading-subheading mb-4">
            <h4 class="pbmit-subtitle">Service Detail</h4>
            <h2 class="pbmit-title">{{ $service->title }}</h2>
        </div>
        
        <div class="row">
            <div class="col-lg-6 mb-4">
                @if($service->secondary_image_url)
                    <img src="{{ $service->secondary_image_url }}" class="img-fluid rounded" alt="{{ $service->title }}">
                @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                        <i class="pbmit-induyst-icon pbmit-induyst-icon-water-drop" style="font-size: 4rem; color: #ccc;"></i>
                    </div>
                @endif
            </div>
            
            <div class="col-lg-6">
                <div class="pbmit-service-description">
                    <h5>Description</h5>
                    <p>{!! \Purifier::clean($service->description) !!}</p>
                </div>
                
                @if ($service->features)
                    <div class="pbmit-service-features mt-4">
                        <h5>Key Features</h5>
                        <ul class="list-unstyled">
                            @foreach(json_decode($service->features) as $feature)
                                <li class="mb-2">
                                    <i class="pbmit-induyst-icon pbmit-induyst-icon-check me-2" style="color: #28a745;"></i>
                                    {{ $feature }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                @if ($service->quote)
                    <blockquote class="blockquote mt-4 p-3 bg-light rounded">
                        <p class="mb-0 fst-italic">"{{ $service->quote }}"</p>
                    </blockquote>
                @endif
            </div>
        </div>
    </div>
</section>
<!-- Service Detail End -->

<!-- Related Services Start -->
@if($relatedServices->count() > 0)
<section class="section-lg pbmit-bg-color-light">
    <div class="container">
        <div class="pbmit-heading-subheading text-center mb-5">
            <h4 class="pbmit-subtitle">Other Services</h4>
            <h2 class="pbmit-title">Related Services</h2>
        </div>
        
        <div class="row">
            @foreach($relatedServices as $relatedService)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="service-card h-100">
                        <div class="service-icon mb-3 w-25">
                            @if($relatedService->svg_inline)
                                {!! $relatedService->svg_inline !!}
                            @else
                                <i class="pbmit-induyst-icon pbmit-induyst-icon-water-drop"></i>
                            @endif
                        </div>
                        <h3 class="service-title">{{ $relatedService->title }}</h3>
                        <p>{{ $relatedService->short_description }}</p>
                        <a href="{{ route('services.show', $relatedService->slug) }}" class="service-link">
                            Learn More <i class="pbmit-induyst-icon pbmit-induyst-icon-next"></i>
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

