@php
    $navItems = $navItems ?? collect();
    $siteName = $data['siteName'] ?? config('app.name', 'Site');
    $theme = $data['theme'] ?? \App\Models\Organization::defaultTheme();
    $showLogo = ($theme['show_logo'] ?? true) && ($theme['show_header_logo'] ?? true);
    $showBrandText = (bool) ($theme['show_brand_text'] ?? true);
    $logoUrl = $showLogo ? ($data['logoUrl'] ?? null) : null;
    $showHeaderCta = (bool) ($theme['show_header_cta'] ?? true);
    $headerCtaText = !empty($theme['header_cta_text']) ? $theme['header_cta_text'] : 'Get in touch';
    $routeSlug = request()->route('slug') ?? ($data['routeSlug'] ?? ($data['organization']->slug ?? null));
    $brandHomeUrl = $data['brandHomeUrl'] ?? ($routeSlug ? route('card.home', ['slug' => $routeSlug]) : url('/'));

    $rawCta = $theme['header_cta_url'] ?? '';
    if (empty($rawCta) || $rawCta === '/contact' || $rawCta === 'contact' || $rawCta === route('contact')) {
        $headerCtaUrl = $data['contactUrl'] ?? ($routeSlug ? route('card.contact', ['slug' => $routeSlug]) : route('contact'));
    } elseif ($routeSlug && str_starts_with($rawCta, '/') && !str_starts_with($rawCta, "/card/{$routeSlug}")) {
        $headerCtaUrl = url("/card/{$routeSlug}" . $rawCta);
    } else {
        $headerCtaUrl = $rawCta;
    }

    $adminPreview = request()->boolean('admin_preview');
    $brandParts = preg_split('/\s+/', trim($siteName), 2) ?: [trim($siteName)];
    $brandFirst = $brandParts[0] ?? $siteName;
    $brandRest = $brandParts[1] ?? null;
@endphp

<header class="hz-header" data-hz-header>
    <nav class="navbar navbar-expand-lg hz-navbar" aria-label="Primary">
        <div class="container hz-navbar-inner">
            @if($logoUrl || $showBrandText)
                <a class="navbar-brand hz-brand" href="{{ $brandHomeUrl }}">
                    @if($logoUrl)
                        <span
                            class="hz-brand-mark"
                            @if($adminPreview)
                                data-admin-section="site-logo"
                                data-admin-compact="1"
                                data-admin-label="Edit Logo"
                                data-admin-edit-url="{{ \App\Support\AdminEditUrls::siteSettings('logo') }}"
                            @endif
                        >
                            <img src="{{ $logoUrl }}" alt="{{ $siteName }}" class="hz-brand-logo">
                        </span>
                    @endif
                    @if($showBrandText)
                        <span
                            class="hz-brand-text"
                            @if($adminPreview)
                                data-admin-section="site-company-name"
                                data-admin-field="company-name"
                                data-admin-compact="1"
                                data-admin-label="Edit Company Name"
                                data-admin-edit-url="{{ \App\Support\AdminEditUrls::siteSettings('company-name') }}"
                                data-preview-field="company-name"
                            @endif
                        >
                            {{ $brandFirst }}@if($brandRest) <span>{{ $brandRest }}</span>@endif
                        </span>
                    @endif
                </a>
            @endif

            <button
                class="hz-toggler d-lg-none"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#hzMainNav"
                aria-controls="hzMainNav"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span></span>
                <span></span>
                <span></span>
            </button>

            <div class="collapse navbar-collapse hz-nav-collapse" id="hzMainNav">
                <ul class="navbar-nav ms-auto align-items-lg-center hz-nav">
                    @foreach ($navItems as $link)
                        <li class="nav-item">
                            <a
                                class="nav-link {{ !empty($link['active']) || collect($link['children'] ?? [])->contains(fn ($c) => !empty($c['active'])) ? 'active' : '' }}"
                                href="{{ $link['url'] }}"
                                target="{{ $link['target'] ?? '_self' }}"
                                @if(!empty($link['active'])) aria-current="page" @endif
                                @if($adminPreview)
                                    data-admin-section="site-nav"
                                    data-admin-compact="1"
                                    data-admin-label="Edit Nav Links"
                                    data-admin-edit-url="{{ \App\Support\AdminEditUrls::siteSettings('navigation') }}"
                                @endif
                            >
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                    @if($showHeaderCta)
                        <li class="nav-item hz-nav-cta">
                            <a
                                class="btn-hz btn-hz-sm"
                                href="{{ $headerCtaUrl }}"
                                @if($adminPreview)
                                    data-admin-section="site-header-cta"
                                    data-admin-field="header-cta-text"
                                    data-admin-compact="1"
                                    data-admin-label="Edit CTA Button"
                                    data-admin-edit-url="{{ \App\Support\AdminEditUrls::siteSettings('header-cta') }}"
                                    data-preview-field="header-cta-text"
                                @endif
                            >{{ $headerCtaText }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</header>
