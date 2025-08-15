@extends('layouts.inner')

@section('title', $service->title)
@section('page_title', $service->title)
@section('description', $service->short_description)

@section('content')
    <!-- Service Detail Start -->
    <section class="site-content service-details">
        <div class="container">
            <div class="row">
                <!-- Sidebar: List all services -->
                <div class="col-md-12 col-xl-3 service-left-col sidebar">
                    <aside class="service-sidebar">
                        <aside class="widget post-list">
                            <div class="all-post-list">
                                <ul>
                                    @foreach ($allServices as $item)
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

                <div class="col-md-12 col-xl-9 service-right-col">
                    <div class="pbmit-short-description">
                        <div class="pbmit-custom-heading">
                            <h3 class="pbmit-title">{{ $service->title }}</h3>
                        </div>
                        <p class="pbmit-firstletter">{!! \Purifier::clean($service->description_intro) !!}</p>
                        <p>{!! \Purifier::clean($service->description) !!}</p>
                    </div>
                    <div class="pbmit-service-feature-image">
                        <img src="{{ $service->primary_image_url }}" alt="{{ $service->title }}">
                    </div>
                    <div data-aos="fade-up" data-aos-duration="800">
                        <div class="pbmit-custom-heading">
                            <h3 class="pbmit-title">{{ $service->short_title }}</h3>
                        </div>
                        @if (!empty($service->features_list))
                            <div class="pbmit-service-features mt-4">
                                <h5>Key Features</h5>
                                <ul class="list-unstyled">
                                     @foreach(($service->features_list) as $feature)
                                        <li>
                                            <i class="pbmit-induyst-icon pbmit-induyst-icon-check me-2"
                                                style="color: #28a745;"></i>
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
        </div>
    </section>

    <!-- Related Services End -->
@endsection
