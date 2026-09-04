@props([
    'stats' => [],
    'title' => 'Impact that compounds',
    'subtitle' => 'By the numbers',
])

@php
    $items = collect($stats)->filter(fn ($stat) => filled($stat['label'] ?? $stat['title'] ?? null))->values();
    $showForPreview = request()->boolean('admin_preview');
@endphp

@if($items->isNotEmpty() || $showForPreview)
<section class="hz-section hz-stats hz-section-dark" aria-label="Impact statistics">
    <div class="container">
        <div class="row justify-content-between align-items-end mb-4 g-3">
            <div class="col-lg-7">
                <p class="hz-eyebrow hz-eyebrow-light" data-preview-field="eyebrow" {!! \App\Support\AdminPreviewAttrs::html('stats', 'eyebrow', 'Edit Eyebrow') !!}>{{ $subtitle }}</p>
                <h2 class="hz-title text-white mb-0" data-preview-field="title" {!! \App\Support\AdminPreviewAttrs::html('stats', 'title', 'Edit Title') !!}>{{ $title }}</h2>
            </div>
        </div>

        <div class="row g-0 hz-stats-grid">
            @forelse($items as $stat)
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
            @empty
                <div class="col-12 p-4 text-white-50">Add stats values in the admin form.</div>
            @endforelse
        </div>
    </div>
</section>
@endif
