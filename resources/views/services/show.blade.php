@extends('layouts.inner')

@section('title', $service->title)
@section('page_title', $service->title)
@section('description', $service->short_description)

@section('content')

    <section class="site-content service-details">
        <div class="container">
            <div class="row">


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
                        <div class="col-md-12">
                            @if ($service->secondary_image_url)
                                <img src="{{ $service->secondary_image_url }}" class="img-fluid"
                                    alt="{{ $service->title }}">
                            @endif
                        </div>

                        <div class="col-md-12">
                            <div class="pbmit-service-description mb-4">
                                <h5 class="fw-bold">Description</h5>
                                <p>{!! \Purifier::clean($service->description) !!}</p>
                            </div>

                            @if ($service->features)
                                <div class="pbmit-service-features mb-4">
                                    <h5>Key Features</h5>
                                    <ul class="list-unstyled">
                                        @foreach (json_decode($service->features) as $feature)
                                            <li class="mb-2 d-flex align-items-start">
                                                <i
                                                    class="pbmit-induyst-icon pbmit-induyst-icon-check me-2 text-success"></i>
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
    </section>
@endsection
