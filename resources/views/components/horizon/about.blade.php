@props([
    'about' => null,
    'features' => null,
    'showLink' => true,
    'previewContext' => 'home',
])

@if($about)
@php
    $image = $about['image'] ?? null;
    $eyebrow = $about['subtitle'] ?: 'Who we are';
    $title = $about['title'] ?: ($data['siteName'] ?? config('app.name'));
    $featureItems = collect($about['points'] ?? $features?->list_items ?? [])->take(4);
    $isAboutPage = $previewContext === 'about-page'
        || request()->routeIs('card.about', 'about');
    $previewSection = $isAboutPage ? 'about-page-intro' : 'about';
    $sectionId = $isAboutPage ? 'about-page-intro' : 'about';
    $aboutPageEditUrl = $isAboutPage ? route('admin.site-pages.edit', 'about') : null;
    $descriptionAdminField = $isAboutPage ? 'description' : 'paragraph_1';
@endphp

<section class="hz-section hz-about" id="{{ $sectionId }}"
    @if(request()->boolean('admin_preview') && $isAboutPage)
        data-admin-section="{{ $previewSection }}"
        data-admin-label="Edit Intro Section"
        data-admin-edit-url="{{ $aboutPageEditUrl }}#about-page-intro"
    @endif
>
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                @if($image)
                    <div class="hz-about-media">
                        <img src="{{ $image }}" alt="{{ $title }}">
                    </div>
                @endif
            </div>
            <div class="col-lg-6">
                <p class="hz-eyebrow" data-preview-field="eyebrow" {!! \App\Support\AdminPreviewAttrs::html($previewSection, 'eyebrow', 'Edit Eyebrow', true, $aboutPageEditUrl ? $aboutPageEditUrl . '#about-page-intro' : null) !!}>{{ $eyebrow }}</p>
                <h2 class="hz-title hz-about-title" data-preview-field="title" {!! \App\Support\AdminPreviewAttrs::html($previewSection, 'title', 'Edit Heading', true, $aboutPageEditUrl ? $aboutPageEditUrl . '#about-page-intro' : null) !!}>{{ $title }}</h2>
                <div class="hz-lead hz-about-copy" data-preview-field="description" data-preview-html="1" {!! \App\Support\AdminPreviewAttrs::html($previewSection, $descriptionAdminField, 'Edit Introduction', true, $aboutPageEditUrl ? $aboutPageEditUrl . '#about-page-intro' : null) !!}>{!! $about['description'] !!}</div>

                @if($featureItems->isNotEmpty())
                    <div class="row g-3 mt-1">
                        @foreach($featureItems as $index => $item)
                            <div class="col-sm-6">
                                <div
                                    class="hz-about-feature"
                                    {!! \App\Support\AdminPreviewAttrs::html(
                                        $previewSection,
                                        'point_' . $index,
                                        'Edit Feature',
                                        true,
                                        $aboutPageEditUrl ? $aboutPageEditUrl . '#about-point-' . $index : null
                                    ) !!}
                                >
                                    <div class="hz-card-icon flex-shrink-0" aria-hidden="true">
                                        <i class="{{ $item['icon'] ?? 'bi bi-check-lg' }}"></i>
                                    </div>
                                    <div>
                                        <h3 class="h6 mb-1" data-preview-field="point-{{ $index }}-title">{{ $item['title'] ?? '' }}</h3>
                                        <p class="small mb-0" data-preview-field="point-{{ $index }}-description">{{ $item['description'] ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($showLink)
                    <div class="mt-4">
                        <a href="{{ route('about') }}" class="btn-hz">
                            More about us <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endif
