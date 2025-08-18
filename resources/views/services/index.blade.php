@extends('layouts.inner')

@section('title', 'Our Services')
@section('page_title', 'Our Services')
@section('description', 'Discover our comprehensive range of water infrastructure and civil engineering services at Veritas Afrika.')

@section('content')
<!-- Services Start -->
<section class="section-lgt">
    <div class="container">
        <div class="pbmit-heading-subheading text-center mb-5">
            <h4 class="pbmit-subtitle">What We Do</h4>
            <h2 class="pbmit-title">Our Professional Services</h2>
        </div>
        
        <div class="row">
            @forelse($services as $service)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="service-card h-100">
                        <div class="service-icon mb-3 w-25">
                            @if($service->svg_inline)
                                {!! $service->svg_inline !!}
                            @else
                                <i class="pbmit-induyst-icon pbmit-induyst-icon-water-drop"></i>
                            @endif
                        </div>
                        <h3 class="service-title">{{ $service->title }}</h3>
                        <p>{{ $service->short_description }}</p>
                        <a href="{{ route('services.show', $service->slug) }}" class="service-link">
                            Learn More <i class="pbmit-induyst-icon pbmit-induyst-icon-next"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        <h4>No Services Available</h4>
                        <p>We're currently updating our service offerings. Please check back soon!</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>
<!-- Services End -->

<!-- Why Choose Us Start -->
<section class="section-lg pbmit-bg-color-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="why-choose-content">
                    <div class="pbmit-heading-subheading">
                        <h4 class="pbmit-subtitle">Why Choose Us</h4>
                        <h2 class="pbmit-title">Excellence in Every Project</h2>
                    </div>
                    <p>At Veritas Afrika, we combine technical expertise with innovative solutions to deliver exceptional results. Our commitment to quality, sustainability, and client satisfaction sets us apart in the industry.</p>
                    
                    <div class="features-list mt-4">
                        <div class="feature-item d-flex align-items-center mb-3">
                            <i class="pbmit-induyst-icon pbmit-induyst-icon-check me-3" style="color: #28a745;"></i>
                            <span>Experienced team of professionals</span>
                        </div>
                        <div class="feature-item d-flex align-items-center mb-3">
                            <i class="pbmit-induyst-icon pbmit-induyst-icon-check me-3" style="color: #28a745;"></i>
                            <span>Innovative and sustainable solutions</span>
                        </div>
                        <div class="feature-item d-flex align-items-center mb-3">
                            <i class="pbmit-induyst-icon pbmit-induyst-icon-check me-3" style="color: #28a745;"></i>
                            <span>Timely project delivery</span>
                        </div>
                        <div class="feature-item d-flex align-items-center mb-3">
                            <i class="pbmit-induyst-icon pbmit-induyst-icon-check me-3" style="color: #28a745;"></i>
                            <span>Competitive pricing</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="why-choose-image">
                    <img src="{{ asset('assets/images/service/service-img-01.jpg') }}" alt="Engineering Services" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Why Choose Us End -->
@endsection
