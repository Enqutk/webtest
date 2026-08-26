@props(['heroes' => collect()])

@php
    $hero = $heroes->first();
@endphp

<section class="hz-hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="hz-eyebrow">Consultancy · Infrastructure · Africa</div>
                <h1 class="hz-hero-brand">Veritas <span>Afrika</span></h1>
                <p class="hz-hero-copy">
                    {{ $hero?->description ?: ($hero?->subtitle ?: 'Multi-disciplinary consultancy delivering civil engineering and infrastructure expertise with clarity, craft, and conviction.') }}
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ $hero?->button_link ?: route('services.index') }}" class="btn-hz">
                        {{ $hero?->text_link ?: 'Explore services' }}
                        <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="{{ route('contact') }}" class="btn-hz-outline">Talk to us</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hz-hero-media">
                    <img
                        src="{{ $hero?->image_url ?: asset('assets/images/banner/banner-img-01.jpg') }}"
                        alt="{{ $hero?->title ?: 'Veritas Afrika' }}"
                    >
                </div>
            </div>
        </div>
    </div>
</section>
