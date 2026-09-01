@props([
    'heroes' => collect(),
    'heroConfig' => [],
])

@php
    $configuredSlides = $heroConfig['slides'] ?? null;
    if (is_array($configuredSlides) && !empty($configuredSlides)) {
        $slides = collect($configuredSlides)
            ->filter(fn ($s) => !isset($s['is_visible']) || (bool)$s['is_visible'])
            ->map(function ($s) {
                $img = $s['image'] ?? $s['image_path'] ?? null;
                if (is_array($img)) {
                    $img = array_values($img)[0] ?? null;
                }
                $imgUrl = (is_string($img) && filled($img))
                    ? (str_starts_with($img, 'http') ? $img : asset('storage/' . ltrim($img, '/')))
                    : null;
                return (object) [
                    'title' => $s['title'] ?? '',
                    'subtitle' => $s['subtitle'] ?? null,
                    'description' => $s['description'] ?? null,
                    'image_url' => $imgUrl,
                    'image_shape' => $s['image_shape'] ?? null,
                    'text_link' => $s['text_link'] ?? 'Explore services',
                    'button_link' => $s['button_link'] ?? route('services.index'),
                ];
            });
    } else {
        $slides = $heroes instanceof \Illuminate\Support\Collection ? $heroes : collect($heroes);
    }

    $hasMultiple = $slides->count() > 1;
    $siteName = $data['siteName'] ?? config('app.name', 'Site');
    $tagline = $data['tagline'] ?? '';
    $heroBadge = $heroConfig['badge'] ?? $heroConfig['subtitle'] ?? ($tagline ? \Illuminate\Support\Str::limit($tagline, 60) : 'Engineering Excellence');
    $heroHeadline = $heroConfig['title'] ?? null;
    $heroCopy = $heroConfig['description'] ?? $tagline;
    $heroCtaText = $heroConfig['cta_text'] ?? 'Explore services';
    $heroCtaUrl = $heroConfig['cta_url'] ?? route('services.index');
    $heroSecCtaText = $heroConfig['secondary_cta_text'] ?? 'Talk to us';
    $heroSecCtaUrl = $heroConfig['secondary_cta_url'] ?? route('contact');
@endphp

<section class="hz-hero" aria-label="Homepage hero">
    @if($slides->isEmpty())
        <div class="container">
            <div class="row align-items-center g-5 hz-hero-slide">
                <div class="col-lg-6">
                    @if($heroBadge)
                        <p class="hz-eyebrow">{{ $heroBadge }}</p>
                    @endif
                    @if($heroHeadline)
                        <h1 class="hz-hero-title mb-3">{{ $heroHeadline }}</h1>
                    @else
                        <x-site-brand as="h1" class="hz-hero-brand" :name="$siteName" />
                    @endif
                    @if($heroCopy)
                        <p class="hz-hero-copy">{{ $heroCopy }}</p>
                    @endif
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ $heroCtaUrl }}" class="btn-hz">
                            {{ $heroCtaText }} <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="{{ $heroSecCtaUrl }}" class="btn-hz-outline">{{ $heroSecCtaText }}</a>
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
                                        <p class="hz-eyebrow">{{ $hero->subtitle }}</p>
                                    @endif

                                    <x-site-brand
                                        :as="$index === 0 ? 'h1' : 'p'"
                                        class="hz-hero-brand"
                                        :name="$siteName"
                                    />

                                    <h2 class="hz-hero-title">{{ $hero->title }}</h2>

                                    @if($hero->description)
                                        <p class="hz-hero-copy">{{ $hero->description }}</p>
                                    @endif

                                    <div class="d-flex flex-wrap gap-3">
                                        <a href="{{ $hero->button_link ?: route('services.index') }}" class="btn-hz">
                                            {{ $hero->text_link ?: 'Explore services' }}
                                            <i class="bi bi-arrow-right"></i>
                                        </a>
                                        <a href="{{ route('contact') }}" class="btn-hz-outline">Talk to us</a>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    @if($hero->image_url)
                                        @php
                                            $slideShape = (!empty($hero->image_shape) && $hero->image_shape !== 'inherit') ? $hero->image_shape : null;
                                            $slideShapeCss = $slideShape ? \App\Models\Organization::getImageShapeCss($slideShape) : '';
                                        @endphp
                                        <div class="hz-hero-media" @if(str_contains($slideShapeCss, 'clip-path')) style="overflow: visible;" @endif>
                                            <img src="{{ $hero->image_url }}" alt="{{ $hero->title }}" @if($slideShapeCss) style="{{ $slideShapeCss }}" @endif>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($hasMultiple)
                <button class="carousel-control-prev hz-hero-control" type="button" data-bs-target="#hzHeroCarousel" data-bs-slide="prev">
                    <span class="hz-hero-control-icon" aria-hidden="true"><i class="bi bi-chevron-left"></i></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next hz-hero-control" type="button" data-bs-target="#hzHeroCarousel" data-bs-slide="next">
                    <span class="hz-hero-control-icon" aria-hidden="true"><i class="bi bi-chevron-right"></i></span>
                    <span class="visually-hidden">Next</span>
                </button>
            @endif
        </div>
    @endif
</section>
