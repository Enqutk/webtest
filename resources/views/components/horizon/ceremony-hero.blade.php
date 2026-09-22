@props([
    'heroConfig' => [],
])

@php
    $cfg = is_array($heroConfig) ? $heroConfig : [];
    $background = \App\Models\Organization::themeFileUrl($cfg['background_image'] ?? null);
    if (! $background) {
        $slide = $cfg['slides'][0] ?? [];
        $slideImage = $slide['image_path'] ?? $slide['image'] ?? null;
        $background = \App\Models\Organization::themeFileUrl($slideImage);
    }
    $title = $cfg['title'] ?? '';
    $copy = $cfg['description'] ?? '';
    $badge = trim((string) ($cfg['badge'] ?? ''));
    $primaryText = $cfg['cta_text'] ?? 'Plan your event';
    $primaryUrl = \App\Models\Organization::publicUrl($cfg['cta_url'] ?? '#inquiry');
    $secondaryText = $cfg['secondary_cta_text'] ?? '';
    $secondaryUrl = \App\Models\Organization::publicUrl($cfg['secondary_cta_url'] ?? '#services');
@endphp

<section class="cm-block cm-hero" id="hero" aria-label="Introduction" {!! \App\Support\AdminPreviewAttrs::html('hero', 'background_image', 'Edit background photo', false) !!}>
    <x-horizon.fill-background
        :image="$background"
        :opacity="$cfg['background_opacity'] ?? 80"
        :shade="$cfg['background_shade'] ?? 42"
        :focus-x="$cfg['background_focus_x'] ?? 50"
        :focus-y="$cfg['background_focus_y'] ?? 40"
        preview-field="background_image"
    />
    <div class="container cm-inner">
        <div class="cm-hero-copy">
            @if($badge !== '')
                <p class="cm-kicker">{{ $badge }}</p>
            @endif
            @if($title !== '')
                <h1 data-preview-field="title" {!! \App\Support\AdminPreviewAttrs::html('hero', 'title', 'Edit Headline') !!}>{{ $title }}</h1>
            @endif
            @if($copy !== '')
                <p class="cm-hero-lead" data-preview-field="description" {!! \App\Support\AdminPreviewAttrs::html('hero', 'description', 'Edit Description') !!}>{{ $copy }}</p>
            @endif
            <div class="cm-actions">
                @if($primaryText !== '')
                    <a href="{{ $primaryUrl }}" class="cm-btn" {!! \App\Support\AdminPreviewAttrs::html('hero', 'cta_text', 'Edit Primary Button') !!}>
                        <span data-preview-field="cta_text">{{ $primaryText }}</span>
                    </a>
                @endif
                @if($secondaryText !== '')
                    <a href="{{ $secondaryUrl }}" class="cm-btn cm-btn-ghost" data-preview-field="secondary_cta_text" {!! \App\Support\AdminPreviewAttrs::html('hero', 'secondary_cta_text', 'Edit Secondary Button') !!}>{{ $secondaryText }}</a>
                @endif
            </div>
        </div>
    </div>
</section>
