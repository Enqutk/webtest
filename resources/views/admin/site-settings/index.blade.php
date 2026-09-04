@extends('admin.site-pages.layout')

@section('title', 'Site Settings')
@section('page-title', 'Site Settings')
@section('page-subtitle', $currentOrg->title)

@push('styles')
<style>
    .site-settings-panel [id]:target {
        scroll-margin-top: 1rem;
        outline: 2px solid rgba(234, 88, 12, 0.35);
        outline-offset: 4px;
        border-radius: 0.75rem;
    }
</style>
@endpush

@section('page-form')
@php
    $contactEmails = $contacts->get('email')?->pluck('value')->filter()->values() ?? collect();
    $contactPhones = $contacts->get('phone')?->pluck('value')->filter()->values() ?? collect();
    if ($contactEmails->isEmpty()) { $contactEmails = collect(['']); }
    if ($contactPhones->isEmpty()) { $contactPhones = collect(['']); }
@endphp

<div
    class="site-settings-panel space-y-4"
    x-data="{
        activeTab: 'header',
        accentColor: '{{ $theme['accent'] ?? '#0f766e' }}',
        accentSecondary: '{{ $theme['accent_secondary'] ?? $theme['accent_dark'] ?? '#0b5f58' }}',
        bgColor: '{{ $theme['bg'] ?? '#f3f6f5' }}',
        surfaceColor: '{{ $theme['surface'] ?? '#ffffff' }}',
        textColor: '{{ $theme['ink'] ?? '#10211f' }}',
        mutedColor: '{{ $theme['muted'] ?? '#5a6b68' }}',
        lineColor: '{{ $theme['line'] ?? '#d7e0dd' }}',
        hashToTab: {
            header: 'header',
            'company-name': 'header',
            tagline: 'header',
            logo: 'header',
            'header-cta': 'header',
            navigation: 'navigation',
            footer: 'footer',
            social: 'footer',
            contact: 'footer',
            'footer-display': 'footer',
            branding: 'colors',
        },
        setTab(tab, hash) {
            this.activeTab = tab;
            if (hash) {
                history.replaceState(null, '', '#' + hash);
                this.$nextTick(() => document.getElementById(hash)?.scrollIntoView({ behavior: 'smooth', block: 'start' }));
            }
        },
        syncFromHash() {
            const hash = window.location.hash.replace('#', '');
            if (!hash) return;
            const tab = this.hashToTab[hash] || 'header';
            this.activeTab = tab;
            this.$nextTick(() => document.getElementById(hash)?.scrollIntoView({ behavior: 'smooth', block: 'start' }));
        },
        saveHash() {
            const hash = window.location.hash.replace('#', '');
            if (hash && this.hashToTab[hash]) return hash;
            const defaults = { header: 'company-name', navigation: 'navigation', footer: 'contact', colors: 'branding' };
            return defaults[this.activeTab] || 'header';
        },
        applyThemePreset(preset) {
            if (preset === 'enku-dark') {
                this.bgColor = '#0b0f19'; this.surfaceColor = '#111827'; this.textColor = '#f9fafb';
                this.mutedColor = '#9ca3af'; this.lineColor = '#1f2937'; this.accentColor = '#00e769'; this.accentSecondary = '#0f766e';
            } else if (preset === 'pure-black') {
                this.bgColor = '#000000'; this.surfaceColor = '#0a0a0a'; this.textColor = '#ffffff';
                this.mutedColor = '#a1a1aa'; this.lineColor = '#27272a'; this.accentColor = '#eab308'; this.accentSecondary = '#ca8a04';
            } else if (preset === 'luxury-navy') {
                this.bgColor = '#061122'; this.surfaceColor = '#0b1d3a'; this.textColor = '#ffffff';
                this.mutedColor = '#94a3b8'; this.lineColor = '#1e293b'; this.accentColor = '#d4af37'; this.accentSecondary = '#f3cf58';
            } else if (preset === 'executive-slate') {
                this.bgColor = '#f8fafc'; this.surfaceColor = '#ffffff'; this.textColor = '#0f172a';
                this.mutedColor = '#64748b'; this.lineColor = '#e2e8f0'; this.accentColor = '#0f766e'; this.accentSecondary = '#0b5f58';
            } else if (preset === 'warm-ivory') {
                this.bgColor = '#fdfbf7'; this.surfaceColor = '#ffffff'; this.textColor = '#1c1917';
                this.mutedColor = '#78716c'; this.lineColor = '#e7e5e4'; this.accentColor = '#ea580c'; this.accentSecondary = '#c2410c';
            }
        }
    }"
    x-init="
        syncFromHash();
        window.addEventListener('hashchange', () => syncFromHash());
    "
>
    <div class="bg-white rounded-2xl border border-slate-200/80 p-2 shadow-sm flex flex-wrap gap-1.5">
        @foreach([
            'header' => ['icon' => 'bi-layout-text-window', 'label' => 'Header'],
            'navigation' => ['icon' => 'bi-list-ul', 'label' => 'Navigation'],
            'footer' => ['icon' => 'bi-layout-bottom', 'label' => 'Footer'],
            'colors' => ['icon' => 'bi-palette', 'label' => 'Colors'],
        ] as $key => $tab)
            <button
                type="button"
                @click="setTab('{{ $key }}')"
                :class="activeTab === '{{ $key }}' ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-slate-600 hover:bg-slate-100'"
                class="px-3 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2"
            >
                <i class="bi {{ $tab['icon'] }}"></i>
                <span>{{ $tab['label'] }}</span>
            </button>
        @endforeach
    </div>

    <form action="{{ route('admin.site-settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <input type="hidden" name="_hash" :value="saveHash()">
        <input type="hidden" name="theme[accent_dark]" :value="accentSecondary">

        {{-- Header --}}
        <div x-show="activeTab === 'header'" x-cloak class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="text-sm font-bold text-slate-900">Header & brand bar</h3>
                <p class="text-xs text-slate-500 mt-0.5">Logo, company name, tagline, and the Get in touch button shown at the top of every page.</p>
            </div>

            <div id="company-name" class="space-y-1.5 scroll-mt-4">
                <label class="block text-xs font-bold text-slate-700">Company name</label>
                <input type="text" name="title" value="{{ $currentOrg->title }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
            </div>

            <div id="tagline" class="space-y-1.5 scroll-mt-4">
                <label class="block text-xs font-bold text-slate-700">Tagline</label>
                <input type="text" name="tagline" value="{{ $currentOrg->tagline }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                    <input type="hidden" name="theme[show_brand_text]" value="0">
                    <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 bg-slate-50 cursor-pointer">
                        <input type="checkbox" name="theme[show_brand_text]" value="1" {{ !empty($theme['show_brand_text']) ? 'checked' : '' }} class="w-4 h-4 rounded text-brand-600">
                        <span class="text-xs font-semibold text-slate-700">Show name in header</span>
                    </label>
                    <input type="hidden" name="theme[show_tagline]" value="0">
                    <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 bg-slate-50 cursor-pointer">
                        <input type="checkbox" name="theme[show_tagline]" value="1" {{ !empty($theme['show_tagline']) ? 'checked' : '' }} class="w-4 h-4 rounded text-brand-600">
                        <span class="text-xs font-semibold text-slate-700">Show tagline in header</span>
                    </label>
                </div>
            </div>

            <div id="logo" class="space-y-1.5 scroll-mt-4">
                <label class="block text-xs font-bold text-slate-700">Logo</label>
                @if($logoUrl)
                    <img src="{{ $logoUrl }}" alt="" class="h-10 w-auto object-contain mb-2">
                @endif
                <input type="file" name="logo" accept="image/*" class="w-full text-xs file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700">
                <input type="hidden" name="theme[show_header_logo]" value="0">
                <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 bg-slate-50 cursor-pointer mt-2">
                    <input type="checkbox" name="theme[show_header_logo]" value="1" {{ !empty($theme['show_header_logo']) ? 'checked' : '' }} class="w-4 h-4 rounded text-brand-600">
                    <span class="text-xs font-semibold text-slate-700">Show logo in header</span>
                </label>
            </div>

            <div id="header-cta" class="pt-2 border-t border-slate-100 space-y-3 scroll-mt-4">
                <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Get in touch button</h4>
                <input type="hidden" name="theme[show_header_cta]" value="0">
                <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 bg-slate-50 cursor-pointer">
                    <input type="checkbox" name="theme[show_header_cta]" value="1" {{ !empty($theme['show_header_cta']) ? 'checked' : '' }} class="w-4 h-4 rounded text-brand-600">
                    <span class="text-xs font-semibold text-slate-700">Show button in header</span>
                </label>
                <div class="grid grid-cols-1 gap-3">
                    <input type="text" name="theme[header_cta_text]" value="{{ $theme['header_cta_text'] ?? 'Get in touch' }}" placeholder="Button text" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                    <input type="text" name="theme[header_cta_url]" value="{{ $theme['header_cta_url'] ?? '/contact' }}" placeholder="/contact" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono">
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <div x-show="activeTab === 'navigation'" x-cloak id="navigation" class="scroll-mt-4">
            @include('admin.site-pages._nav-links')
        </div>

        {{-- Footer --}}
        <div x-show="activeTab === 'footer'" x-cloak class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm space-y-6">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="text-sm font-bold text-slate-900">Footer & contact</h3>
                <p class="text-xs text-slate-500 mt-0.5">Social icons, contact details, and footer visibility.</p>
            </div>

            <div id="social" class="scroll-mt-4 pt-4 border-t border-slate-100">
                <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-3">Social icons</h4>
                @include('admin.site-pages._social-links', ['bare' => true])
            </div>

            <div id="contact" class="pt-4 border-t border-slate-100 space-y-3 scroll-mt-4">
                <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Contact details</h4>
                <p class="text-[11px] text-slate-500">Shown in the footer Contact column.</p>
                <div class="space-y-2" x-data="{
                    emails: @json($contactEmails->values()->all()),
                    phones: @json($contactPhones->values()->all()),
                    addEmail() { this.emails.push(''); },
                    addPhone() { this.phones.push(''); }
                }">
                    <template x-for="(email, i) in emails" :key="'email-'+i">
                        <div class="flex gap-2">
                            <input type="email" :name="'contact_emails['+i+']'" x-model="emails[i]" placeholder="Email address" class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                            <button type="button" @click="emails.splice(i, 1)" x-show="emails.length > 1" class="px-2 text-rose-500"><i class="bi bi-x-lg"></i></button>
                        </div>
                    </template>
                    <button type="button" @click="addEmail()" class="text-[11px] font-bold text-brand-700">+ Add email</button>

                    <template x-for="(phone, i) in phones" :key="'phone-'+i">
                        <div class="flex gap-2 mt-2">
                            <input type="text" :name="'contact_phones['+i+']'" x-model="phones[i]" placeholder="Phone number" class="flex-1 px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                            <button type="button" @click="phones.splice(i, 1)" x-show="phones.length > 1" class="px-2 text-rose-500"><i class="bi bi-x-lg"></i></button>
                        </div>
                    </template>
                    <button type="button" @click="addPhone()" class="text-[11px] font-bold text-brand-700">+ Add phone</button>

                    <textarea name="address" rows="2" placeholder="Street address" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs mt-2">{{ $currentOrg->address }}</textarea>
                    <input type="text" name="po_box" value="{{ $currentOrg->po_box }}" placeholder="P.O. Box" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                </div>
            </div>

            <div id="footer-display" class="pt-4 border-t border-slate-100 space-y-3 scroll-mt-4">
                <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Footer visibility</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach([
                        'show_footer_tagline' => 'Tagline under logo',
                        'show_footer_nav' => 'Explore & Connect columns',
                        'show_footer_social' => 'Social icons',
                        'show_footer_contact' => 'Contact block',
                        'show_footer_credit' => 'Developer credit',
                    ] as $key => $label)
                        <input type="hidden" name="theme[{{ $key }}]" value="0">
                        <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 bg-slate-50 cursor-pointer">
                            <input type="checkbox" name="theme[{{ $key }}]" value="1" {{ !empty($theme[$key]) ? 'checked' : '' }} class="w-4 h-4 rounded text-brand-600">
                            <span class="text-xs font-semibold text-slate-700">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Colors --}}
        <div x-show="activeTab === 'colors'" x-cloak id="branding" class="bg-white rounded-2xl border border-slate-200/80 p-5 lg:p-6 shadow-sm space-y-6 scroll-mt-4">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="text-sm font-bold text-slate-900">Background, colors & styling</h3>
                <p class="text-xs text-slate-500 mt-0.5">Pick a 1-click theme preset or customize each color with swatches and hex values.</p>
            </div>

            @include('admin.partials._theme-color-palette')

            <p class="text-[11px] text-slate-500 pt-2 border-t border-slate-100">
                For fonts, image shapes, and full brand customizer,
                <a href="{{ route('admin.organizations.edit', $currentOrg) }}" class="font-bold text-brand-700 hover:underline">open Organization & Brand Settings →</a>
            </p>
        </div>

        <div x-show="activeTab !== 'navigation'" x-cloak class="sticky bottom-0 pt-2 pb-1 bg-gradient-to-t from-slate-50 via-slate-50 to-transparent">
            <button type="submit" class="w-full px-4 py-3 bg-brand-600 hover:bg-brand-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-brand-600/30">Save site settings</button>
        </div>
    </form>
</div>
@endsection
