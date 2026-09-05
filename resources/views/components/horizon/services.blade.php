@props([
    'services' => collect(),
    'limit' => null,
    'showHeader' => true,
    'eyebrow' => 'What we deliver',
    'title' => 'Our services',
    'description' => null,
    'ctaText' => 'All services',
    'ctaUrl' => null,
    'layout' => 'cards',
    'icons' => [],
])

@php
    $items = $limit ? $services->take($limit) : $services;
    $routeSlug = $data['routeSlug'] ?? request()->route('slug');
    $isGallery = $layout === 'gallery';
    $targetCtaUrl = $ctaUrl ?: ($data['servicesUrl'] ?? route('services.index'));
    $serviceUrl = function (?string $slug) use ($routeSlug) {
        if ($routeSlug) {
            return route('card.services.show', ['slug' => $routeSlug, 'service_slug' => $slug]);
        }

        return route('services.show', $slug);
    };
    $defaultIcons = ['bi bi-braces', 'bi bi-kanban', 'bi bi-phone', 'bi bi-globe2', 'bi bi-people', 'bi bi-lightning'];
@endphp

<section class="hz-section hz-services {{ $isGallery ? 'hz-services-gallery' : 'bg-surface border-top border-bottom border-hz' }}" id="services">
    <div class="container">
        @if($showHeader)
            <div class="row justify-content-between align-items-end mb-4 g-3">
                <div class="col-lg-7">
                    <p class="hz-eyebrow" data-preview-field="eyebrow" {!! \App\Support\AdminPreviewAttrs::html('services', 'eyebrow', 'Edit Eyebrow') !!}>{{ $eyebrow }}</p>
                    <h2 class="hz-title mb-0" data-preview-field="title" {!! \App\Support\AdminPreviewAttrs::html('services', 'title', 'Edit Title') !!}>{{ $title }}</h2>
                    @if($description)
                        <p class="hz-lead text-muted mt-2 mb-0" data-preview-field="description" {!! \App\Support\AdminPreviewAttrs::html('services', 'description', 'Edit Description') !!}>{{ $description }}</p>
                    @else
                        <p class="hz-lead text-muted mt-2 mb-0" data-preview-field="description" style="display:none"></p>
                    @endif
                </div>
                <div class="col-lg-auto">
                    <a href="{{ $targetCtaUrl }}" class="btn-hz-outline" data-preview-field="cta_text" {!! \App\Support\AdminPreviewAttrs::html('services', 'cta_text', 'Edit Button') !!}>{{ $ctaText }}</a>
                </div>
            </div>
        @endif

        @if($isGallery)
            <div class="hz-gallery">
                @forelse($items as $index => $service)
                    @php
                        $image = $service->main_image_url;
                        $icon = $icons[$service->slug] ?? $defaultIcons[$index % count($defaultIcons)];
                        $href = $serviceUrl($service->slug);
                    @endphp
                    <a
                        href="{{ $href }}"
                        class="hz-gallery-tile"
                        {!! \App\Support\AdminPreviewAttrs::html('services', 'service_'.$service->id, 'Edit Service', false) !!}
                    >
                        @if($image)
                            <img src="{{ $image }}" alt="" class="hz-gallery-tile-photo">
                        @endif
                        <span class="hz-gallery-tile-icon" aria-hidden="true"><i class="{{ $icon }}"></i></span>
                        <span class="hz-gallery-tile-index">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="hz-gallery-tile-body">
                            <span class="hz-gallery-tile-title">{{ $service->title }}</span>
                            <span class="hz-gallery-tile-copy">{{ $service->short_description }}</span>
                            <span class="hz-gallery-tile-link">Open <i class="bi bi-arrow-up-right"></i></span>
                        </span>
                    </a>
                @empty
                    <p class="text-muted mb-0">Gallery pieces will appear here once published.</p>
                @endforelse
            </div>
        @else
            <div class="row g-4">
                @forelse($items as $index => $service)
                    @php
                        $image = $service->main_image_url;
                        $href = $serviceUrl($service->slug);
                    @endphp
                    <div class="col-md-6 col-lg-4">
                        <article
                            class="hz-service-card"
                            {!! \App\Support\AdminPreviewAttrs::html('services', 'service_'.$service->id, 'Edit Service', false) !!}
                        >
                            <a href="{{ $href }}" class="hz-service-card-media">
                                @if($image)
                                    <img src="{{ $image }}" alt="{{ $service->title }}">
                                @endif
                                <span class="hz-service-card-index">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                            </a>
                            <div class="hz-service-card-body">
                                <h3>
                                    <a href="{{ $href }}">{{ $service->title }}</a>
                                </h3>
                                <p>{{ $service->short_description }}</p>
                                <a href="{{ $href }}" class="hz-link">
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
        @endif
    </div>
</section>
