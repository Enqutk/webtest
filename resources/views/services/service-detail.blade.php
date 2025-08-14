@extends('layouts.inner')

@section('content')
<section class="section-xxl fade-section">
    <div class="container">
        <div class="pbmit-heading-subheading mb-4">
            <h4 class="pbmit-subtitle">Service Detail</h4>
            <h2 class="pbmit-title">{{ $service->title }}</h2>
        </div>
        <div class="row">
            <div class="col-lg-6 mb-4">
                <img src="{{ $service->secondary_image_url }}" class="img-fluid" alt="{{ $service->title }}">
            </div>
            <div class="col-lg-6">
                <div class="pbmit-service-description">
                    <h5>Description</h5>
                    <p>{!! $service->description !!}</p>
                </div>
                @if ($service->features)
                    <div class="pbmit-service-features mt-3">
                        <h5>Features</h5>
                        <div>{!! $service->features !!}</div>
                    </div>
                @endif
                @if ($service->quote)
                    <blockquote class="blockquote mt-3">
                        <p class="mb-0">{{ $service->quote }}</p>
                    </blockquote>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
