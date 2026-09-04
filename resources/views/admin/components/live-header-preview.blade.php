@php
    /** @var \App\Models\Organization|null $activeOrg */
    $activeOrg = $activeOrg ?? \App\Models\Organization::resolveCurrent();
    $theme = is_array($activeOrg->theme) ? $activeOrg->theme : \App\Models\Organization::defaultTheme();

    $accent = $theme['accent'] ?? '#0f766e';
    $bg = $theme['bg'] ?? '#f3f6f5';
    $surface = $theme['surface'] ?? '#ffffff';
    $ink = $theme['ink'] ?? '#10211f';
    $muted = $theme['muted'] ?? '#5a6b68';
    $line = $theme['line'] ?? '#d7e0dd';
    $displayFont = $theme['font_display'] ?? 'Fraunces';
    $bodyFont = $theme['font_body'] ?? 'Outfit';

    $showLogo = (bool) ($theme['show_logo'] ?? true);
    $showHeaderLogo = (bool) ($theme['show_header_logo'] ?? true);
    $showBrandText = (bool) ($theme['show_brand_text'] ?? true);
    $showTagline = (bool) ($theme['show_tagline'] ?? true);

    $logoUrl = ($showLogo && $showHeaderLogo) ? $activeOrg->getFirstMediaUrl('logo') : null;
    $siteName = $activeOrg->title ?? config('app.name', 'Site');
    $tagline = ($showTagline ? ($activeOrg->tagline ?? '') : '');

    $showHeaderCta = (bool) ($theme['show_header_cta'] ?? true);
    $headerCtaText = !empty($theme['header_cta_text']) ? $theme['header_cta_text'] : 'Get in touch';
@endphp

<div class="bg-white rounded-2xl border border-slate-200/80 shadow-md p-4 lg:p-6 sticky top-2 z-10 backdrop-blur-md bg-white/95 transition-all mb-5">
    <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
        <div class="flex items-center gap-2">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
            <span class="text-xs font-bold text-slate-800 uppercase tracking-wider">Live Header Preview (current saved)</span>
        </div>
        <div class="flex items-center gap-3 text-xs text-slate-500">
            <span class="font-mono">Accent: {{ $accent }}</span>
        </div>
    </div>

    <div class="rounded-xl border p-4 transition-all shadow-inner"
         style="background: {{ $bg }}; border-color: {{ $line }}; color: {{ $ink }};">
        <div class="flex items-center justify-between">
            <!-- Brand -->
            <div class="flex items-center gap-3">
                @if($logoUrl)
                    <img src="{{ $logoUrl }}" alt="Logo" class="h-8 w-auto object-contain">
                @else
                    @if($showLogo && $showHeaderLogo)
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white font-bold text-sm shadow-sm" style="background: {{ $accent }}">
                            <span>{{ mb_substr($siteName, 0, 1) }}</span>
                        </div>
                    @endif
                @endif

                @if($showBrandText)
                    <div>
                        <span class="text-lg font-bold tracking-tight block leading-tight" style="font-family: '{{ $displayFont }}'; color: {{ $ink }};" title="{{ $siteName }}">
                            {{ $siteName }}
                        </span>
                        @if($showTagline && $tagline)
                            <span class="text-[10px] block" style="color: {{ $muted }};">{{ $tagline }}</span>
                        @endif
                    </div>
                @endif
            </div>

            <!-- CTA -->
            @if($showHeaderCta)
                <div>
                    <span class="px-3.5 py-1.5 rounded-lg text-white font-bold text-xs shadow-md"
                          style="background: {{ $accent }}; font-family: '{{ $bodyFont }}'; color: {{ $accent === '#ffffff' ? '#0b1d3a' : '#ffffff' }};">
                        {{ $headerCtaText }}
                    </span>
                </div>
            @endif
        </div>

        <!-- Nav mock (visual only) -->
        <div class="hidden md:flex items-center gap-6 text-xs font-medium mt-4"
             style="font-family: '{{ $bodyFont }}'; color: {{ $muted }};">
            <span class="font-bold border-b-2 pb-0.5" style="color: {{ $accent }}; border-color: {{ $accent }};">Home</span>
            <span>About</span>
            <span>Services</span>
            <span>Portfolio</span>
            <span>Contact</span>
        </div>
    </div>
</div>

