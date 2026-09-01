@props([
    'services' => collect(),
    'limit' => null,
    'showHeader' => true,
    'eyebrow' => 'What we deliver',
    'title' => 'Our services',
    'description' => null,
    'ctaText' => 'All services',
    'ctaUrl' => null,
])

@php
    $items = $limit ? $services->take($limit) : $services;
    $targetCtaUrl = $ctaUrl ?: route('services.index');
@endphp

<section class="hz-section hz-services bg-surface border-top border-bottom border-hz" id="services">
    <div class="container">
        @if($showHeader)
            <div class="row justify-content-between align-items-end mb-4 g-3">
                <div class="col-lg-7">
                    <p class="hz-eyebrow">{{ $eyebrow }}</p>
                    <h2 class="hz-title mb-0">{{ $title }}</h2>
                    @if($description)
                        <p class="hz-lead text-muted mt-2 mb-0">{{ $description }}</p>
                    @endif
                </div>
                <div class="col-lg-auto">
                    <a href="{{ $targetCtaUrl }}" class="btn-hz-outline">{{ $ctaText }}</a>
                </div>
            </div>
        @endif

        <div class="row g-4">
            @forelse($items as $index => $service)
                @php
                    $image = $service->main_image_url;
                @endphp
                <div class="col-md-6 col-lg-4">
                    <article class="hz-service-card">
                        <a href="{{ route('services.show', $service->slug) }}" class="hz-service-card-media">
                            @if($image)
                                <img src="{{ $image }}" alt="{{ $service->title }}">
                            @endif
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
