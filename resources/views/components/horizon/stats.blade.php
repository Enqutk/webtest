@props(['stats' => []])

@if(count($stats))
<section class="hz-section hz-section-dark">
    <div class="container">
        <div class="row g-4">
            @foreach($stats as $stat)
                <div class="col-6 col-lg-3">
                    <div class="hz-stat">
                        <div
                            class="hz-stat-value"
                            data-counter="{{ (int) ($stat['value'] ?? 0) }}"
                            data-suffix="{{ $stat['suffix'] ?? '' }}"
                        >0{{ $stat['suffix'] ?? '' }}</div>
                        <div class="hz-stat-label">{{ $stat['label'] ?? ($stat['title'] ?? '') }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
