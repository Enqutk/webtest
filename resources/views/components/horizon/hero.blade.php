@props(['heroes' => collect()])

@php
    $slides = $heroes instanceof \Illuminate\Support\Collection ? $heroes : collect($heroes);
    $hasMultiple = $slides->count() > 1;
@endphp

<section class="hz-hero" aria-label="Homepage hero">
    @if($slides->isEmpty())
        <div class="container">
            <div class="row align-items-center g-5 hz-hero-slide">
                <div class="col-lg-6">
                    <p class="hz-eyebrow">Consultancy · Infrastructure · Africa</p>
                    <h1 class="hz-hero-brand">Veritas <span>Afrika</span></h1>
                    <p class="hz-hero-copy">
                        Multi-disciplinary consultancy delivering civil engineering and infrastructure expertise with clarity, craft, and conviction.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('services.index') }}" class="btn-hz">
                            Explore services <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="{{ route('contact') }}" class="btn-hz-outline">Talk to us</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hz-hero-media">
                        <img src="{{ asset('assets/images/banner-slider-img/slider2-04.jpg') }}" alt="Veritas Afrika">
                    </div>
                </div>
            </div>
        </div>
    @else
        <div
            id="hzHeroCarousel"
            class="carousel slide"
            @if($hasMultiple) data-bs-ride="carousel" data-bs-interval="6500" @endif
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

                                    @if($index === 0)
                                        <h1 class="hz-hero-brand">Veritas <span>Afrika</span></h1>
                                    @else
                                        <p class="hz-hero-brand">Veritas <span>Afrika</span></p>
                                    @endif

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
                                    <div class="hz-hero-media">
                                        <img
                                            src="{{ $hero->image_url ?: asset('assets/images/banner-slider-img/slider2-04.jpg') }}"
                                            alt="{{ $hero->title }}"
                                        >
                                    </div>
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
