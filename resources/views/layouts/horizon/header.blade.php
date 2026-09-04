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
    $editHeaderUrl = $adminPreview ? \App\Support\AdminEditUrls::siteSettings('header') : null;
    $editNavUrl = $adminPreview ? \App\Support\AdminEditUrls::siteSettings('navigation') : null;
@endphp

<header class="hz-header" data-hz-header>
    <nav class="navbar navbar-expand-lg hz-navbar" aria-label="Primary">
        <div class="container hz-navbar-inner">
            @if($logoUrl || $showBrandText)
                <a class="navbar-brand hz-brand" href="{{ $brandHomeUrl }}"
                   @if($adminPreview) data-admin-section="site-brand" data-admin-label="Edit Header" data-admin-edit-url="{{ $editHeaderUrl }}" @endif>
                    <x-site-brand :name="$siteName" :logo="$logoUrl" :show-text="$showBrandText" />
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

            <div class="collapse navbar-collapse hz-nav-collapse" id="hzMainNav"
                 @if($adminPreview) data-admin-section="site-nav" data-admin-label="Edit Navigation" data-admin-edit-url="{{ $editNavUrl }}" @endif>
                <ul class="navbar-nav ms-auto align-items-lg-center hz-nav">
                    @foreach ($navItems as $link)
                        @if(!empty($link['children']))
                            <li class="nav-item dropdown">
                                <a
                                    class="nav-link dropdown-toggle {{ !empty($link['active']) || collect($link['children'])->contains(fn ($c) => !empty($c['active'])) ? 'active' : '' }}"
                                    href="{{ $link['url'] }}"
                                    id="nav-{{ \Illuminate\Support\Str::slug($link['label']) }}"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                >
                                    {{ $link['label'] }}
                                </a>
                                <ul class="dropdown-menu hz-dropdown" aria-labelledby="nav-{{ \Illuminate\Support\Str::slug($link['label']) }}">
                                    <li>
                                        <a class="dropdown-item {{ !empty($link['active']) ? 'active' : '' }}" href="{{ $link['url'] }}">
                                            Overview
                                        </a>
                                    </li>
                                    @foreach ($link['children'] as $child)
                                        <li>
                                            <a
                                                class="dropdown-item {{ !empty($child['active']) ? 'active' : '' }}"
                                                href="{{ $child['url'] }}"
                                                target="{{ $child['target'] ?? '_self' }}"
                                            >
                                                {{ $child['label'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a
                                    class="nav-link {{ !empty($link['active']) ? 'active' : '' }}"
                                    href="{{ $link['url'] }}"
                                    target="{{ $link['target'] ?? '_self' }}"
                                    @if(!empty($link['active'])) aria-current="page" @endif
                                >
                                    {{ $link['label'] }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                    @if($showHeaderCta)
                        <li class="nav-item hz-nav-cta"
                            @if($adminPreview) data-admin-section="site-header-cta" data-admin-label="Edit Header Button" data-admin-edit-url="{{ $editHeaderUrl }}" @endif>
                            <a class="btn-hz btn-hz-sm" href="{{ $headerCtaUrl }}">{{ $headerCtaText }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</header>
