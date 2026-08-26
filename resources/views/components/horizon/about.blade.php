@props(['about' => null, 'features' => null])

@if($about)
<section class="hz-section" id="about">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <img src="{{ $about['image'] }}" alt="{{ $about['title'] }}" class="w-100 border border-hz">
            </div>
            <div class="col-lg-6">
                <div class="hz-eyebrow">{{ $about['subtitle'] ?: 'About us' }}</div>
                <h2 class="hz-title">{{ $about['title'] ?: 'Built for lasting infrastructure' }}</h2>
                <div class="hz-lead mb-4">{!! $about['description'] !!}</div>

                @if($features?->list_items)
                    <div class="row g-3">
                        @foreach(collect($features->list_items)->take(4) as $item)
                            <div class="col-sm-6">
                                <div class="d-flex gap-3">
                                    <div class="hz-card-icon flex-shrink-0">
                                        <i class="{{ $item['icon'] ?? 'bi bi-check-lg' }}"></i>
                                    </div>
                                    <div>
                                        <h3 class="h6 mb-1">{{ $item['title'] ?? '' }}</h3>
                                        <p class="small text-muted mb-0">{{ $item['description'] ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('about') }}" class="hz-link">Learn more about us <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
