@props([
    'config' => [],
])

@php
    $cfg = is_array($config) ? $config : [];
    $background = \App\Models\Organization::themeFileUrl($cfg['background_image'] ?? null);
    $href = \App\Models\Organization::publicUrl($cfg['button_url'] ?? '#inquiry');
@endphp

<section class="cm-block cm-cta" id="cta">
    <x-horizon.fill-background
        :image="$background"
        :opacity="$cfg['background_opacity'] ?? 80"
        :shade="$cfg['background_shade'] ?? 55"
        :focus-x="$cfg['background_focus_x'] ?? 50"
        :focus-y="$cfg['background_focus_y'] ?? 50"
    />
    <div class="container cm-inner">
        @if(filled($cfg['title'] ?? null))
            <h2 data-preview-field="title" {!! \App\Support\AdminPreviewAttrs::html('cta', 'title', 'Edit Title') !!}>{{ $cfg['title'] }}</h2>
        @endif
        @if(filled($cfg['eyebrow'] ?? null))
            <p class="cm-cta-line" data-preview-field="eyebrow">{{ $cfg['eyebrow'] }}</p>
        @endif
        @if(filled($cfg['description'] ?? null))
            <p class="cm-copy" data-preview-field="description" {!! \App\Support\AdminPreviewAttrs::html('cta', 'description', 'Edit Description') !!}>{{ $cfg['description'] }}</p>
        @endif
        @if(filled($cfg['button_text'] ?? null))
            <a href="{{ $href }}" class="cm-btn" {!! \App\Support\AdminPreviewAttrs::html('cta', 'button_text', 'Edit Button') !!}>
                <span data-preview-field="button_text">{{ $cfg['button_text'] }}</span>
            </a>
        @endif
    </div>
</section>
