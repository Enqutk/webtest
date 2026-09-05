@props([
    'heroes' => collect(),
    'heroConfig' => [],
])

@php
    $configuredSlides = $heroConfig['slides'] ?? null;
    $heroesList = $heroes instanceof \Illuminate\Support\Collection ? $heroes : collect($heroes);
    if (is_array($configuredSlides) && !empty($configuredSlides)) {
        $slides = collect($configuredSlides)
            ->filter(fn ($s) => !isset($s['is_visible']) || (bool)$s['is_visible'])
            ->values()
            ->map(function ($s, $index) use ($heroConfig, $heroesList) {
                $img = $s['image'] ?? $s['image_path'] ?? null;
                if (is_array($img)) {
                    $img = array_values($img)[0] ?? null;
                }
                $imgUrl = (is_string($img) && filled($img))
                    ? (str_starts_with($img, 'http') ? $img : asset('storage/' . ltrim($img, '/')))
                    : null;

                if (! $imgUrl && $heroesList->has($index)) {
                    $heroRecord = $heroesList->get($index);
                    $imgUrl = filled($heroRecord->image_url ?? null)
                        ? $heroRecord->image_url
                        : ($heroRecord->getFirstMediaUrl('image') ?: null);
                }

                return (object) [
                    'title' => $s['title'] ?? '',
                    'subtitle' => $s['subtitle'] ?? $s['eyebrow'] ?? null,
                    'description' => $s['description'] ?? null,
                    'image_url' => $imgUrl,
                    'image_shape' => $s['image_shape'] ?? null,
                    'image_focus_x' => $s['image_focus_x'] ?? 50,
                    'image_focus_y' => $s['image_focus_y'] ?? 50,
                    'text_link' => $s['text_link'] ?? $s['button_label'] ?? ($heroConfig['cta_text'] ?? 'Explore services'),
                    'button_link' => $s['button_link'] ?? $s['button_url'] ?? ($heroConfig['cta_url'] ?? route('services.index')),
                ];
            });
    } else {
        $slides = $heroesList->map(function ($hero) {
            return (object) [
                'title' => $hero->title ?? '',
                'subtitle' => $hero->subtitle ?? null,
                'description' => $hero->description ?? null,
                'image_url' => filled($hero->image_url ?? null)
                    ? $hero->image_url
                    : ($hero->getFirstMediaUrl('image') ?: null),
                'image_shape' => null,
                'image_focus_x' => 50,
                'image_focus_y' => 50,
                'text_link' => $hero->text_link ?: 'Explore services',
                'button_link' => $hero->button_link ?: route('services.index'),
            ];
        });
    }
@endphp

@php
    $hasMultiple = $slides->count() > 1;
    $siteName = $data['siteName'] ?? config('app.name', 'Site');
    $tagline = $data['tagline'] ?? '';
    $heroBadge = $heroConfig['badge'] ?? $heroConfig['subtitle'] ?? ($tagline ? \Illuminate\Support\Str::limit($tagline, 60) : 'Engineering Excellence');
    $heroHeadline = $heroConfig['title'] ?? null;
    $heroCopy = $heroConfig['description'] ?? $tagline;
    $heroCtaText = $heroConfig['cta_text'] ?? 'Explore services';
    $heroCtaUrl = !empty($heroConfig['cta_url']) ? $heroConfig['cta_url'] : ($data['servicesUrl'] ?? route('services.index'));
    $heroSecCtaText = $heroConfig['secondary_cta_text'] ?? 'Talk to us';
    $heroSecCtaUrl = !empty($heroConfig['secondary_cta_url']) ? $heroConfig['secondary_cta_url'] : ($data['contactUrl'] ?? route('contact'));
@endphp

<section class="hz-hero" id="hero" aria-label="Homepage hero">
    @if($slides->isEmpty())
        <div class="container">
            <div class="row align-items-center g-5 hz-hero-slide">
                <div class="col-lg-6">
                    @if($heroBadge)
                        <p class="hz-eyebrow" data-preview-field="badge" {!! \App\Support\AdminPreviewAttrs::html('hero', 'badge', 'Edit Badge') !!}>{{ $heroBadge }}</p>
                    @endif
                    @if($heroHeadline)
                        <h1 class="hz-hero-title mb-3" data-preview-field="title" {!! \App\Support\AdminPreviewAttrs::html('hero', 'title', 'Edit Headline') !!}>{{ $heroHeadline }}</h1>
                    @else
                        <x-site-brand as="h1" class="hz-hero-brand" :name="$siteName" />
                    @endif
                    @if($heroCopy)
                        <p class="hz-hero-copy" data-preview-field="description" {!! \App\Support\AdminPreviewAttrs::html('hero', 'description', 'Edit Description') !!}>{{ $heroCopy }}</p>
                    @endif
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ $heroCtaUrl }}" class="btn-hz" {!! \App\Support\AdminPreviewAttrs::html('hero', 'cta_text', 'Edit Primary Button') !!}>
                            <span data-preview-field="cta_text">{{ $heroCtaText }}</span> <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="{{ $heroSecCtaUrl }}" class="btn-hz-outline" data-preview-field="secondary_cta_text" {!! \App\Support\AdminPreviewAttrs::html('hero', 'secondary_cta_text', 'Edit Secondary Button') !!}>{{ $heroSecCtaText }}</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div
            id="hzHeroCarousel"
            class="carousel slide hz-hero-carousel"
            @if($hasMultiple) data-bs-ride="carousel" data-bs-interval="4000" data-bs-pause="hover" data-bs-touch="true" @endif
        >
            @if($hasMultiple)
                <div class="carousel-indicators hz-hero-indicators">
                    @foreach($slides as $index => $slide)
                        <button
                            type="button"
                            data-bs-target="#hzHeroCarousel"
                            data-bs-slide-to="{{ $index }}"
                            class="{{ $index === 0 ? 'active' : '' }}"
                            aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                            aria-label="Slide {{ $index + 1 }}"
                        ></button>
                    @endforeach
                </div>
            @endif

            <div class="carousel-inner">
                @foreach($slides as $index => $hero)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <div class="container">
                            <div class="row align-items-center g-5 hz-hero-slide">
                                <div class="col-lg-6">
                                    @if($hero->subtitle)
                                        <p class="hz-eyebrow" data-preview-field="badge" {!! \App\Support\AdminPreviewAttrs::html('hero', 'badge', 'Edit Badge') !!}>{{ $hero->subtitle }}</p>
                                    @endif

                                    <x-site-brand
                                        :as="$index === 0 ? 'h1' : 'p'"
                                        class="hz-hero-brand"
                                        :name="$siteName"
                                    />

                                    <h2 class="hz-hero-title" data-preview-field="title" {!! \App\Support\AdminPreviewAttrs::html('hero', 'title', 'Edit Headline') !!}>{{ $hero->title }}</h2>

                                    @if($hero->description)
                                        <p class="hz-hero-copy" data-preview-field="description" {!! \App\Support\AdminPreviewAttrs::html('hero', 'description', 'Edit Description') !!}>{{ $hero->description }}</p>
                                    @endif

                                    <div class="d-flex flex-wrap gap-3">
                                        <a href="{{ $hero->button_link ?: ($data['servicesUrl'] ?? route('services.index')) }}" class="btn-hz" {!! \App\Support\AdminPreviewAttrs::html('hero', 'cta_text', 'Edit Primary Button') !!}>
                                             <span data-preview-field="cta_text">{{ $hero->text_link ?: 'Explore services' }}</span>
                                             <i class="bi bi-arrow-right"></i>
                                         </a>
                                         <a href="{{ $heroSecCtaUrl }}" class="btn-hz-outline" data-preview-field="secondary_cta_text" {!! \App\Support\AdminPreviewAttrs::html('hero', 'secondary_cta_text', 'Edit Secondary Button') !!}>{{ $heroSecCtaText }}</a>
                                     </div>
                                </div>
                                <div class="col-lg-6">
                                    @if($hero->image_url)
                                        @php
                                            $slideShape = (!empty($hero->image_shape) && $hero->image_shape !== 'inherit') ? $hero->image_shape : null;
                                            $slideShapeCss = $slideShape ? \App\Models\Organization::getImageShapeCss($slideShape) : '';
                                            $focusPosition = \App\Models\Organization::imageObjectPosition($hero->image_focus_x ?? null, $hero->image_focus_y ?? null);
                                            $imgStyles = collect([
                                                'object-position: ' . $focusPosition,
                                                $slideShapeCss ?: null,
                                            ])->filter()->implode('; ');
                                        @endphp
                                        <div class="hz-hero-media" @if(str_contains($slideShapeCss, 'clip-path')) style="overflow: visible;" @endif>
                                            <x-horizon.focused-image
                                                :src="$hero->image_url"
                                                :alt="$hero->title"
                                                :focus-x="$hero->image_focus_x ?? 50"
                                                :focus-y="$hero->image_focus_y ?? 50"
                                                :extra-style="$slideShapeCss"
                                            />
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</section>
