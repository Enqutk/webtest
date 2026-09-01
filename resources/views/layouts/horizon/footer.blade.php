@php
    $siteName = $data['siteName'] ?? config('app.name', 'Site');
    $theme = $data['theme'] ?? \App\Models\Organization::defaultTheme();
    $tagline = ($theme['show_footer_tagline'] ?? true) ? ($data['tagline'] ?? '') : '';
    $navItems = $navItems ?? collect();
    $showBrandText = (bool) ($theme['show_brand_text'] ?? true);
    $showLogo = (bool) ($theme['show_logo'] ?? true);
    $logoUrl = $showLogo ? ($data['logoUrl'] ?? null) : null;
    $showFooterNav = (bool) ($theme['show_footer_nav'] ?? true);
    $showFooterSocial = (bool) ($theme['show_footer_social'] ?? true) && (bool) ($theme['show_social_links'] ?? true);
    $showFooterContact = (bool) ($theme['show_footer_contact'] ?? true);
    $showFooterCredit = (bool) ($theme['show_footer_credit'] ?? true);
@endphp

<footer class="hz-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5">
                <div class="hz-footer-brand">
                    <x-site-brand :name="$siteName" :logo="$logoUrl" :show-text="$showBrandText" />
                </div>
                @if($tagline)
                    <p class="mb-3 hz-footer-tagline">{{ $tagline }}</p>
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
                        @forelse($navItems as $link)
                            <li><a href="{{ $link['url'] }}">{{ $link['label'] }}</a></li>
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
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                        <li><a href="{{ url('/mgt') }}">Admin</a></li>
                    </ul>
                </div>
            @endif
            @if($showFooterContact)
                <div class="col-lg-3">
                    <h6 class="text-white mb-3">Contact</h6>
                    @if(!empty($data['address'] ?? null))
                        <p class="mb-2 hz-address">{{ $data['address'] }}</p>
                    @endif
                    @if(!empty($data['po_box'] ?? null))
                        <p class="mb-2 opacity-75 hz-pobox"><small>P.O. Box: {{ $data['po_box'] }}</small></p>
                    @endif
                    @foreach(($data['email'] ?? []) as $email)
                        <p class="mb-1"><a href="mailto:{{ $email }}">{{ $email }}</a></p>
                    @endforeach
                    @foreach(($data['phone'] ?? []) as $phone)
                        <p class="mb-1"><a href="tel:{{ preg_replace('/\s+/', '', $phone) }}">{{ $phone }}</a></p>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="hz-footer-bottom d-flex flex-column flex-md-row justify-content-between gap-2">
            <div>&copy; {{ date('Y') }} {{ $siteName }}. All rights reserved.</div>
            @if($showFooterCredit)
                <div>Developed by <a href="https://tetercreatives.com" target="_blank" rel="noopener">Teter PLC</a></div>
            @endif
        </div>
    </div>
</footer>
