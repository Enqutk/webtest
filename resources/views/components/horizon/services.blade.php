@props([
    'services' => collect(),
    'limit' => null,
    'showHeader' => true,
])

@php
    $items = $limit ? $services->take($limit) : $services;
    $fallbacks = [
        'assets/images/banner-slider-img/slider2-04.jpg',
        'assets/images/banner-slider-img/slider3-04.jpg',
        'assets/images/homepage-2/about-img-01.png',
        'assets/images/banner-slider-img/slider-07.png',
    ];
@endphp

<section class="hz-section hz-services bg-surface border-top border-bottom border-hz" id="services">
    <div class="container">
        @if($showHeader)
            <div class="row justify-content-between align-items-end mb-4 g-3">
                <div class="col-lg-7">
                    <p class="hz-eyebrow">What we do</p>
                    <h2 class="hz-title mb-0">Services shaped around real water challenges</h2>
                </div>
                <div class="col-lg-auto">
                    <a href="{{ route('services.index') }}" class="btn-hz-outline">All services</a>
                </div>
            </div>
        @endif

        <div class="row g-4">
            @forelse($items as $index => $service)
                @php
                    $image = $service->main_image_url
                        ?: asset($fallbacks[$index % count($fallbacks)]);
                @endphp
                <div class="col-md-6 col-lg-4">
                    <article class="hz-service-card">
                        <a href="{{ route('services.show', $service->slug) }}" class="hz-service-card-media">
                            <img src="{{ $image }}" alt="{{ $service->title }}">
                            <span class="hz-service-card-index">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                        </a>
                        <div class="hz-service-card-body">
                            <h3>
                                <a href="{{ route('services.show', $service->slug) }}">{{ $service->title }}</a>
                            </h3>
                            <p>{{ $service->short_description }}</p>
                            <a href="{{ route('services.show', $service->slug) }}" class="hz-link">
                                Learn more <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-muted mb-0">Services will appear here once published in the admin panel.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
