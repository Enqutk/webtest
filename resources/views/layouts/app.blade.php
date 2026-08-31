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

        $fonts = array_unique(array_filter([$fontDisplay, $fontBody]));
        $fontQueries = [];
        foreach ($fonts as $font) {
            $encodedFont = str_replace(' ', '+', $font);
            if ($font === 'Fraunces') {
                $fontQueries[] = 'family=Fraunces:opsz,wght@9..144,500;9..144,700';
            } elseif ($font === 'Playfair Display') {
                $fontQueries[] = 'family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400';
            } elseif ($font === 'Cinzel') {
                $fontQueries[] = 'family=Cinzel:wght@400;600;700';
            } elseif ($font === 'Lora') {
                $fontQueries[] = 'family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400';
            } else {
                $fontQueries[] = "family={$encodedFont}:wght@400;500;600;700;800";
            }
        }
        $googleFontsUrl = 'https://fonts.googleapis.com/css2?' . implode('&', $fontQueries) . '&display=swap';

        $serifFonts = ['Fraunces', 'Playfair Display', 'Lora', 'Cinzel'];
        $displayFallback = in_array($fontDisplay, $serifFonts) ? 'Georgia, serif' : 'sans-serif';
        $bodyFallback = in_array($fontBody, $serifFonts) ? 'Georgia, serif' : 'sans-serif';
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
