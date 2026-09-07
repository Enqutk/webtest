@props([
    'as' => 'span',
    'name' => null,
    'logo' => null,
    'showText' => null,
    'showLogo' => null,
    'context' => 'site',
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

    if ($context === 'hero') {
        $nameSection = 'hero';
        $nameField = 'hero-display-name';
        $nameLabel = 'Edit hero name';
        $nameEditUrl = \App\Support\AdminEditUrls::homeSections('hero');
        $logoSection = 'hero';
        $logoField = 'hero-brand-logo';
        $logoLabel = 'Edit hero logo';
        $logoEditUrl = \App\Support\AdminEditUrls::homeSections('hero');
    } else {
        $nameSection = 'site-company-name';
        $nameField = 'company-name';
        $nameLabel = 'Edit name';
        $nameEditUrl = \App\Support\AdminEditUrls::siteSettings('company-name');
        $logoSection = 'site-logo';
        $logoField = 'site-logo';
        $logoLabel = 'Edit logo';
        $logoEditUrl = \App\Support\AdminEditUrls::siteSettings('logo');
    }

    $namePreview = \App\Support\AdminPreviewAttrs::html($nameSection, $nameField, $nameLabel, true, $nameEditUrl);
    $logoPreview = \App\Support\AdminPreviewAttrs::html($logoSection, $logoField, $logoLabel, true, $logoEditUrl);
@endphp

@if($logoUrl || ($shouldShowText && $brand !== ''))
    <{{ $as }} {{ $attributes->class(['hz-brand-mark' => (bool) $logoUrl]) }}>
        @if($logoUrl)
            <span class="hz-brand-mark-asset" {!! $logoPreview !!}>
                <img src="{{ $logoUrl }}" alt="{{ $brand }}" class="hz-brand-logo" data-preview-field="{{ $logoField }}">
            </span>
        @endif
        @if($shouldShowText && $brand !== '')
            <span class="hz-brand-text" data-preview-field="{{ $nameField }}" {!! $namePreview !!}>
                {{ $first }}@if($rest) <span>{{ $rest }}</span>@endif
            </span>
        @endif
    </{{ $as }}>
@endif
