@props([
    'as' => 'span',
    'name' => null,
    'logo' => null,
    'showText' => null,
    'showLogo' => null,
])

@php
    $theme = $data['theme'] ?? \App\Models\Organization::defaultTheme();
    $shouldShowText = $showText !== null ? (bool) $showText : (bool) ($theme['show_brand_text'] ?? true);
    $brand = trim((string) ($name ?? ($data['siteName'] ?? config('app.name', 'Site'))));
    $logoUrl = $logo ?? ($data['logoUrl'] ?? null);
    if ($showLogo === false) {
        $logoUrl = null;
    }
    $parts = preg_split('/\s+/', $brand, 2) ?: [$brand];
    $first = $parts[0] ?? $brand;
    $rest = $parts[1] ?? null;
    $namePreview = \App\Support\AdminPreviewAttrs::html(
        'site-company-name',
        'company-name',
        'Edit name',
        true,
        \App\Support\AdminEditUrls::siteSettings('company-name')
    );
    $logoPreview = \App\Support\AdminPreviewAttrs::html(
        'site-logo',
        'site-logo',
        'Edit logo',
        true,
        \App\Support\AdminEditUrls::siteSettings('logo')
    );
@endphp

@if($logoUrl || $shouldShowText)
    <{{ $as }} {{ $attributes->class(['hz-brand-mark' => (bool) $logoUrl]) }}>
        @if($logoUrl)
            <span class="hz-brand-mark-asset" {!! $logoPreview !!}>
                <img src="{{ $logoUrl }}" alt="{{ $brand }}" class="hz-brand-logo" data-preview-field="site-logo">
            </span>
        @endif
        @if($shouldShowText)
            <span class="hz-brand-text" data-preview-field="company-name" {!! $namePreview !!}>
                {{ $first }}@if($rest) <span>{{ $rest }}</span>@endif
            </span>
        @endif
    </{{ $as }}>
@endif
