@props([
    'title' => 'Have a project in mind?',
    'text' => null,
    'button' => 'Start a conversation',
    'href' => null,
])

@php
    $copy = $text
        ?: ($data['tagline'] ?? null)
        ?: 'Tell us about your project — we’ll help shape a clear path from concept to delivery.';
@endphp

<section class="hz-cta">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <h2 class="hz-title mb-2" data-preview-field="title" {!! \App\Support\AdminPreviewAttrs::html('cta', 'title', 'Edit Title') !!}>{{ $title }}</h2>
                <p class="mb-0" data-preview-field="description" {!! \App\Support\AdminPreviewAttrs::html('cta', 'description', 'Edit Description') !!}>{{ $copy }}</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ $href ?? ($data['contactUrl'] ?? route('contact')) }}" class="btn-hz" {!! \App\Support\AdminPreviewAttrs::html('cta', 'button_text', 'Edit Button') !!}>
                    <span data-preview-field="button_text">{{ $button }}</span> <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</section>
