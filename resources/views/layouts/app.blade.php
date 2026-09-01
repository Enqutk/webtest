<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Home') | {{ $data['siteName'] ?? config('app.name') }}</title>
    <meta name="description" content="@yield('description', $data['metaDescription'] ?? ($data['siteName'] ?? config('app.name')))">
    <meta name="robots" content="{{ config('app.env') === 'production' ? 'index, follow' : 'noindex, nofollow' }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ $data['faviconUrl'] ?? $data['logoUrl'] ?? asset('images/fevicon.png') }}">
    @php
        $theme = $data['theme'] ?? \App\Models\Organization::defaultTheme();
        $theme['accent_soft'] = $theme['accent_soft']
            ?? \App\Models\Organization::hexToRgba($theme['accent'] ?? '#0f766e', 0.12);
        $fontDisplay = $theme['font_display'] ?? 'Fraunces';
        $fontBody = $theme['font_body'] ?? 'Outfit';
        $brandFont = $theme['brand_font_family'] ?? null;
        $taglineFont = $theme['tagline_font_family'] ?? null;
        $navFont = $theme['nav_font_family'] ?? null;

        $googleFontsUrl = \App\Models\Organization::getGoogleFontsUrl([$fontDisplay, $fontBody, $brandFont, $taglineFont, $navFont]);

        $serifFonts = ['Fraunces', 'Playfair Display', 'Lora', 'Cinzel'];
        $displayFallback = in_array($fontDisplay, $serifFonts) ? 'Georgia, serif' : 'sans-serif';
        $bodyFallback = in_array($fontBody, $serifFonts) ? 'Georgia, serif' : 'sans-serif';
        $brandFallback = in_array($brandFont, $serifFonts) ? 'Georgia, serif' : 'sans-serif';
        $taglineFallback = in_array($taglineFont, $serifFonts) ? 'Georgia, serif' : 'sans-serif';
        $navFallback = in_array($navFont, $serifFonts) ? 'Georgia, serif' : 'sans-serif';
    @endphp

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="{{ $googleFontsUrl }}" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --hz-bg: {{ $theme['bg'] ?? '#f3f6f5' }};
            --hz-surface: {{ $theme['surface'] ?? '#ffffff' }};
            --hz-ink: {{ $theme['ink'] ?? '#10211f' }};
            --hz-muted: {{ $theme['muted'] ?? '#5a6b68' }};
            --hz-line: {{ $theme['line'] ?? '#d7e0dd' }};
            --hz-accent: {{ $theme['accent'] ?? '#0f766e' }};
            --hz-accent-dark: {{ $theme['accent_dark'] ?? '#0b5f58' }};
            --hz-accent-soft: {{ $theme['accent_soft'] }};
            --hz-dark: {{ $theme['dark'] ?? '#0a1615' }};
            --font-display: '{{ $fontDisplay }}', {{ $displayFallback }};
            --font-body: '{{ $fontBody }}', {{ $bodyFallback }};
            @if(!empty($brandFont)) --hz-brand-font-family: '{{ $brandFont }}', {{ $brandFallback }}; @endif
            @if(!empty($theme['brand_font_weight'])) --hz-brand-font-weight: {{ $theme['brand_font_weight'] }}; @endif
            @if(!empty($theme['brand_letter_spacing'])) --hz-brand-letter-spacing: {{ $theme['brand_letter_spacing'] }}; @endif

            @if(!empty($taglineFont)) --hz-tagline-font-family: '{{ $taglineFont }}', {{ $taglineFallback }}; @endif
            @if(!empty($theme['tagline_font_style'])) --hz-tagline-font-style: {{ $theme['tagline_font_style'] }}; @endif
            @if(!empty($theme['tagline_font_weight'])) --hz-tagline-font-weight: {{ $theme['tagline_font_weight'] }}; @endif

            @if(!empty($navFont)) --hz-nav-font-family: '{{ $navFont }}', {{ $navFallback }}; @endif
            @if(!empty($theme['nav_font_weight'])) --hz-nav-font-weight: {{ $theme['nav_font_weight'] }}; @endif
            @if(!empty($theme['nav_spacing'])) --hz-nav-spacing: {{ $theme['nav_spacing'] }}; @endif
        }
    </style>
    @stack('styles')
</head>
<body>
    @include('layouts.horizon.header')

    <main>
        @yield('content')
    </main>

    @include('layouts.horizon.footer')

    @stack('scripts')
</body>
</html>
