@php
    $siteName = $data['siteName'] ?? config('app.name', 'Site');
    $theme = $data['theme'] ?? \App\Models\Organization::defaultTheme();
    $tagline = ($theme['show_footer_tagline'] ?? true) ? ($data['tagline'] ?? '') : '';
    $navItems = $navItems ?? collect();
    $footerNavItems = $footerNavItems ?? $navItems;
    $showBrandText = (bool) ($theme['show_brand_text'] ?? true);
    $showLogo = (bool) ($theme['show_logo'] ?? true);
    $logoUrl = $showLogo ? ($data['logoUrl'] ?? null) : null;
    $showFooterNav = (bool) ($theme['show_footer_nav'] ?? true);
    $showFooterSocial = (bool) ($theme['show_footer_social'] ?? true) && (bool) ($theme['show_social_links'] ?? true);
    $showFooterContact = (bool) ($theme['show_footer_contact'] ?? true);
    $showFooterCredit = (bool) ($theme['show_footer_credit'] ?? true);

    $adminPreview = request()->boolean('admin_preview');
    $routeSlug = request()->route('slug') ?? ($data['routeSlug'] ?? ($data['organization']->slug ?? null));
    $connectLinks = $theme['footer_connect_links'] ?? [['label' => 'Contact', 'url' => '/contact']];
    $brandParts = preg_split('/\s+/', trim($siteName), 2) ?: [trim($siteName)];
    $brandFirst = $brandParts[0] ?? $siteName;
    $brandRest = $brandParts[1] ?? null;
@endphp

<footer class="hz-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5">
                <a href="{{ $data['brandHomeUrl'] ?? url('/') }}" class="hz-footer-brand d-inline-block text-decoration-none">
                    @if($logoUrl)
                        <span
                            class="hz-brand-mark d-inline-block"
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
                            class="hz-brand-text d-inline-block"
                            @if($adminPreview)
                                data-admin-section="site-company-name"
                                data-admin-compact="1"
                                data-admin-label="Edit Company Name"
                                data-admin-edit-url="{{ \App\Support\AdminEditUrls::siteSettings('company-name') }}"
                            @endif
                        >
                            {{ $brandFirst }}@if($brandRest) <span>{{ $brandRest }}</span>@endif
                        </span>
                    @endif
                </a>
                @if($tagline)
                    <p
                        class="mb-3 hz-footer-tagline"
                        @if($adminPreview)
                            data-admin-section="site-tagline"
                            data-admin-compact="1"
                            data-admin-label="Edit Tagline"
                            data-admin-edit-url="{{ \App\Support\AdminEditUrls::siteSettings('tagline') }}"
                        @endif
                    >{{ $tagline }}</p>
                @endif
                @if($showFooterSocial)
                    <div class="hz-social">
                        <x-social-media />
                    </div>
                @endif
            </div>
            @if($showFooterNav)
                <div class="col-6 col-lg-2">
                    <h6 class="text-white mb-3">Explore</h6>
                    <ul class="list-unstyled d-grid gap-2">
                        @forelse($footerNavItems as $link)
                            <li><a href="{{ $link['url'] }}"
                                @if($adminPreview)
                                    data-admin-section="site-nav"
                                    data-admin-compact="1"
                                    data-admin-label="Edit Nav Links"
                                    data-admin-edit-url="{{ \App\Support\AdminEditUrls::siteSettings('navigation') }}"
                                @endif
                            >{{ $link['label'] }}</a></li>
                        @empty
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li><a href="{{ route('about') }}">About</a></li>
                            <li><a href="{{ route('services.index') }}">Services</a></li>
                            <li><a href="{{ route('portfolio.index') }}">Portfolio</a></li>
                        @endforelse
                    </ul>
                </div>
                <div class="col-6 col-lg-2">
                    <h6 class="text-white mb-3">Connect</h6>
                    <ul class="list-unstyled d-grid gap-2">
                        @foreach($connectLinks as $link)
                            @php
                                $rawUrl = $link['url'] ?? '/contact';
                                if ($rawUrl === '/contact' || $rawUrl === 'contact') {
                                    $linkUrl = $data['contactUrl'] ?? ($routeSlug ? route('card.contact', ['slug' => $routeSlug]) : route('contact'));
                                } elseif ($routeSlug && str_starts_with($rawUrl, '/') && !str_starts_with($rawUrl, "/card/{$routeSlug}")) {
                                    $linkUrl = url("/card/{$routeSlug}" . $rawUrl);
                                } else {
                                    $linkUrl = $rawUrl;
                                }
                            @endphp
                            <li><a href="{{ $linkUrl }}"
                                @if($adminPreview)
                                    data-admin-section="site-nav"
                                    data-admin-compact="1"
                                    data-admin-label="Edit Nav Links"
                                    data-admin-edit-url="{{ \App\Support\AdminEditUrls::siteSettings('navigation') }}"
                                @endif
                            >{{ $link['label'] ?? 'Link' }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if($showFooterContact)
                <div class="col-lg-3">
                    <h6 class="text-white mb-3">Contact</h6>
                    @if(!empty($data['address'] ?? null))
                        <p
                            class="mb-2 hz-address"
                            @if($adminPreview)
                                data-admin-section="site-contact"
                                data-admin-compact="1"
                                data-admin-label="Edit Contact"
                                data-admin-edit-url="{{ \App\Support\AdminEditUrls::siteSettings('contact') }}"
                            @endif
                        >{{ $data['address'] }}</p>
                    @endif
                    @if(!empty($data['po_box'] ?? null))
                        <p
                            class="mb-2 opacity-75 hz-pobox"
                            @if($adminPreview)
                                data-admin-section="site-contact"
                                data-admin-compact="1"
                                data-admin-label="Edit Contact"
                                data-admin-edit-url="{{ \App\Support\AdminEditUrls::siteSettings('contact') }}"
                            @endif
                        ><small>P.O. Box: {{ $data['po_box'] }}</small></p>
                    @endif
                    @foreach(($data['email'] ?? []) as $email)
                        <p
                            class="mb-1"
                            @if($adminPreview)
                                data-admin-section="site-contact"
                                data-admin-compact="1"
                                data-admin-label="Edit Contact"
                                data-admin-edit-url="{{ \App\Support\AdminEditUrls::siteSettings('contact') }}"
                            @endif
                        ><a href="mailto:{{ $email }}">{{ $email }}</a></p>
                    @endforeach
                    @foreach(($data['phone'] ?? []) as $phone)
                        <p
                            class="mb-1"
                            @if($adminPreview)
                                data-admin-section="site-contact"
                                data-admin-compact="1"
                                data-admin-label="Edit Contact"
                                data-admin-edit-url="{{ \App\Support\AdminEditUrls::siteSettings('contact') }}"
                            @endif
                        ><a href="tel:{{ preg_replace('/\s+/', '', $phone) }}">{{ $phone }}</a></p>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="hz-footer-bottom d-flex flex-column flex-md-row justify-content-between gap-2">
            <div>&copy; {{ date('Y') }} {{ $siteName }}. All rights reserved.</div>
            @if($showFooterCredit)
                <div
                    @if($adminPreview)
                        data-admin-section="site-footer-credit"
                        data-admin-compact="1"
                        data-admin-label="Edit Footer Visibility"
                        data-admin-edit-url="{{ \App\Support\AdminEditUrls::siteSettings('footer-display') }}"
                    @endif
                >Developed by <a href="https://tetercreatives.com" target="_blank" rel="noopener">Teter PLC</a></div>
            @endif
        </div>
    </div>
</footer>
