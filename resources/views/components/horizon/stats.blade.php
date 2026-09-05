@props([
    'stats' => [],
    'title' => 'Impact that compounds',
    'subtitle' => 'By the numbers',
    'variant' => 'dark',
])

@php
    $items = collect($stats)->filter(fn ($stat) => filled($stat['label'] ?? $stat['title'] ?? null))->values();
    $showForPreview = request()->boolean('admin_preview');

    $parseStatValue = function ($stat): array {
        $raw = (string) ($stat['value'] ?? $stat['number'] ?? '0');
        if (isset($stat['suffix']) && $stat['suffix'] !== '' && ! str_contains($raw, (string) $stat['suffix'])) {
            $raw .= $stat['suffix'];
        }
        if (preg_match('/^(\d+)(.*)$/', $raw, $matches)) {
            return [
                'display' => $raw,
                'counter' => (int) $matches[1],
                'suffix' => $matches[2],
            ];
        }

        return [
            'display' => $raw,
            'counter' => (int) $raw,
            'suffix' => '',
        ];
    };
@endphp

@if($items->isNotEmpty() || $showForPreview)
        <section class="hz-section hz-stats {{ $variant === 'light' ? 'hz-stats-light' : 'hz-section-dark' }}" id="stats" aria-label="Impact statistics">
    <div class="container">
        <div class="row justify-content-between align-items-end mb-4 g-3">
            <div class="col-lg-7">
                <p class="hz-eyebrow {{ $variant === 'light' ? '' : 'hz-eyebrow-light' }}" data-preview-field="eyebrow" {!! \App\Support\AdminPreviewAttrs::html('stats', 'eyebrow', 'Edit Eyebrow') !!}>{{ $subtitle }}</p>
                <h2 class="hz-title {{ $variant === 'light' ? '' : 'text-white' }} mb-0" data-preview-field="title" {!! \App\Support\AdminPreviewAttrs::html('stats', 'title', 'Edit Title') !!}>{{ $title }}</h2>
            </div>
        </div>

        <div class="row g-0 hz-stats-grid">
            @forelse($items as $index => $stat)
                @php $parsed = $parseStatValue($stat); @endphp
                <div class="col-6 col-lg-3">
                    <div
                        class="hz-stat"
                        {!! \App\Support\AdminPreviewAttrs::html('stats', 'stat_'.$index, 'Edit Stat', false) !!}
                    >
                        <div
                            class="hz-stat-value"
                            data-preview-field="stat-{{ $index }}-value"
                            data-counter="{{ $parsed['counter'] }}"
                            data-suffix="{{ $parsed['suffix'] }}"
                        >0{{ $parsed['suffix'] }}</div>
                        <div class="hz-stat-label" data-preview-field="stat-{{ $index }}-label">{{ $stat['label'] ?? ($stat['title'] ?? '') }}</div>
                    </div>
                </div>
            @empty
                <div class="col-12 p-4 text-white-50">Add stats values in the admin form.</div>
            @endforelse
        </div>
    </div>
</section>
@endif
