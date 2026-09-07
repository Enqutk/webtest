<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title') · Kimem Cards</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/fevicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=JetBrains+Mono:wght@500;600&family=Outfit:wght@400;500;600&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy: #0b1d3a;
            --navy-deep: #061122;
            --gold: #d4af37;
            --gold-bright: #f3cf58;
            --ochre: #a6803c;
            --bg: #fcfbf9;
            --font-display: 'Playfair Display', Georgia, serif;
            --font-brand: 'Cinzel', 'Playfair Display', serif;
            --font-mono: 'JetBrains Mono', ui-monospace, monospace;
            --font-sans: 'Outfit', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            margin: 0;
            min-height: 100%;
        }

        body {
            font-family: var(--font-sans);
            color: var(--navy);
            background: var(--bg);
            -webkit-font-smoothing: antialiased;
        }

        .error-page {
            position: relative;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .error-page::before {
            content: '';
            position: fixed;
            inset: 0;
            pointer-events: none;
            background-image: radial-gradient(rgba(11, 29, 58, 0.08) 0.5px, transparent 0.5px);
            background-size: 3px 3px;
            opacity: 0.08;
            z-index: 0;
        }

        .error-nav {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1.1rem 1.5rem;
            border-bottom: 1px solid rgba(212, 175, 55, 0.18);
            background: linear-gradient(to bottom, rgba(11, 29, 58, 0.96), rgba(11, 29, 58, 0.82));
        }

        @media (min-width: 768px) {
            .error-nav { padding-inline: 4vw; }
        }

        .error-logo {
            font-family: var(--font-brand);
            color: var(--gold);
            text-transform: uppercase;
            letter-spacing: 0.22em;
            font-size: 0.95rem;
            font-weight: 700;
            text-decoration: none;
        }

        .error-logo:hover { color: var(--gold-bright); }

        .error-nav-meta {
            font-family: var(--font-mono);
            font-size: 0.66rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.72);
        }

        .error-main {
            position: relative;
            z-index: 1;
            flex: 1;
            display: grid;
            place-items: center;
            padding: 2.25rem 1.25rem 2.75rem;
        }

        .error-inner {
            position: relative;
            width: min(100%, 42rem);
            text-align: center;
            padding: 3.25rem 0 1.25rem;
        }

        .error-code {
            position: absolute;
            left: 50%;
            top: 42%;
            transform: translate(-50%, -58%);
            font-family: var(--font-display);
            font-size: clamp(8rem, 28vw, 14rem);
            line-height: 0.8;
            letter-spacing: -0.04em;
            color: rgba(11, 29, 58, 0.07);
            margin: 0;
            user-select: none;
            pointer-events: none;
            z-index: 0;
            white-space: nowrap;
        }

        .error-eyebrow,
        .error-title,
        .error-copy,
        .error-actions {
            position: relative;
            z-index: 1;
        }

        .error-eyebrow {
            font-family: var(--font-mono);
            font-size: 0.72rem;
            letter-spacing: 0.32em;
            text-transform: uppercase;
            color: var(--gold);
            font-weight: 600;
            margin: 0 0 1rem;
        }

        .error-title {
            font-family: var(--font-display);
            font-size: clamp(1.65rem, 3.6vw, 2.45rem);
            line-height: 1.15;
            letter-spacing: -0.02em;
            margin: 0 0 0.85rem;
            color: var(--navy);
        }

        .error-copy {
            margin: 0 auto 1.75rem;
            max-width: 38ch;
            color: rgba(11, 29, 58, 0.72);
            font-size: 1rem;
            line-height: 1.7;
        }

        .error-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.85rem;
        }

        .error-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 2.85rem;
            padding: 0.85rem 1.8rem;
            font-family: var(--font-mono);
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.24em;
            text-transform: uppercase;
            text-decoration: none;
            border: 1px solid var(--gold);
            transition: transform 0.25s ease, background 0.25s ease, color 0.25s ease, box-shadow 0.25s ease;
        }

        .error-btn--primary {
            background: var(--gold);
            color: var(--navy);
            box-shadow: 0 16px 40px -18px rgba(0, 0, 0, 0.45);
        }

        .error-btn--primary:hover {
            transform: translateY(-2px);
            background: transparent;
            color: var(--navy);
        }

        .error-btn--ghost {
            background: transparent;
            color: var(--ochre);
            border-color: rgba(212, 175, 55, 0.5);
        }

        .error-btn--ghost:hover {
            transform: translateY(-2px);
            border-color: var(--gold);
            color: var(--navy);
            background: rgba(212, 175, 55, 0.1);
        }

        .error-footer {
            position: relative;
            z-index: 1;
            padding: 1.25rem 1.5rem 1.75rem;
            text-align: center;
            font-family: var(--font-mono);
            font-size: 0.68rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: rgba(11, 29, 58, 0.45);
        }

        .error-grid {
            pointer-events: none;
            position: absolute;
            inset: 18% 8% auto;
            height: 52%;
            opacity: 0.28;
            z-index: 0;
        }

        .error-grid span {
            position: absolute;
            background: linear-gradient(to right, transparent, rgba(197, 160, 89, 0.5), transparent);
        }

        .error-grid span:nth-child(1) { inset-inline: 0; top: 18%; height: 1px; }
        .error-grid span:nth-child(2) { inset-inline: 0; top: 62%; height: 1px; }
        .error-grid span:nth-child(3) {
            inset-block: 0;
            left: 50%;
            width: 1px;
            background: linear-gradient(to bottom, transparent, rgba(197, 160, 89, 0.45), transparent);
        }
    </style>
</head>
<body>
    @php
        $homeUrl = url('/');
        $profileUrl = null;
        $path = ltrim(request()->path(), '/');
        if (preg_match('#^card/([A-Za-z0-9\-]+)#', $path, $matches)) {
            $profileUrl = url('/card/'.$matches[1]);
        }
    @endphp

    <div class="error-page">
        <div class="error-grid" aria-hidden="true">
            <span></span><span></span><span></span>
        </div>

        <nav class="error-nav">
            <a class="error-logo" href="{{ $homeUrl }}">Kimem Cards</a>
            <span class="error-nav-meta">@yield('nav_meta', 'Error')</span>
        </nav>

        <main class="error-main">
            <div class="error-inner">
                <p class="error-code" aria-hidden="true">@yield('code')</p>
                <p class="error-eyebrow">@yield('eyebrow')</p>
                <h1 class="error-title">@yield('heading')</h1>
                <p class="error-copy">@yield('message')</p>
                <div class="error-actions">
                    @yield('actions')
                </div>
            </div>
        </main>

        <footer class="error-footer">
            Kimem Cards · {{ date('Y') }}
        </footer>
    </div>
</body>
</html>
