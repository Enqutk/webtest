@extends('admin.site-pages.layout')

@section('title', 'Site Settings')
@section('page-title', 'Site Settings')
@section('page-subtitle', $currentOrg->title)

@push('styles')
<style>
    .site-settings-panel .site-setting-item:target {
        background: linear-gradient(90deg, rgba(234, 88, 12, 0.06), transparent 70%);
        border-radius: 0.75rem;
        padding-left: 0.75rem;
        padding-right: 0.75rem;
        margin-left: -0.75rem;
        margin-right: -0.75rem;
    }
    .site-settings-nav button.is-active {
        color: rgb(234 88 12);
        font-weight: 700;
    }
</style>
@endpush

@section('page-form')
@php
    $contactEmails = $contacts->get('email')?->pluck('value')->filter()->values() ?? collect();
    $contactPhones = $contacts->get('phone')?->pluck('value')->filter()->values() ?? collect();
    if ($contactEmails->isEmpty()) { $contactEmails = collect(['']); }
    if ($contactPhones->isEmpty()) { $contactPhones = collect(['']); }

    $jumpSections = [
        ['id' => 'header', 'label' => 'Header'],
        ['id' => 'company-name', 'label' => 'Name'],
        ['id' => 'navigation', 'label' => 'Nav links'],
        ['id' => 'social', 'label' => 'Social'],
        ['id' => 'contact', 'label' => 'Contact'],
        ['id' => 'branding', 'label' => 'Colors'],
    ];
@endphp

<div
    class="site-settings-panel"
    x-data="{
        active: window.location.hash.replace('#', '') || 'header',
        jump(id) {
            this.active = id;
            history.replaceState(null, '', '#' + id);
            document.getElementById(id)?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }"
    x-init="
        if (window.location.hash) {
            const id = window.location.hash.replace('#', '');
            active = id;
            setTimeout(() => document.getElementById(id)?.scrollIntoView({ behavior: 'smooth', block: 'start' }), 100);
        }
        window.addEventListener('hashchange', () => {
            active = window.location.hash.replace('#', '') || 'header';
            document.getElementById(active)?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    "
>
    <nav class="site-settings-nav flex flex-wrap gap-x-3 gap-y-1 mb-4 pb-3 border-b border-slate-200/80">
        @foreach($jumpSections as $section)
            <button
                type="button"
                @click="jump('{{ $section['id'] }}')"
                :class="active === '{{ $section['id'] }}' ? 'is-active' : 'text-slate-500 hover:text-slate-800'"
                class="text-[11px] font-semibold transition"
            >{{ $section['label'] }}</button>
        @endforeach
    </nav>

    <form action="{{ route('admin.site-settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_hash" :value="active">

        @include('admin.site-settings._section-label', ['id' => 'header', 'label' => 'Header'])

        @component('admin.site-settings._setting-item', [
            'id' => 'company-name',
            'icon' => 'bi-building',
            'title' => 'Company name',
            'hint' => 'Shown in the header, footer, and browser tab.',
        ])
            <input type="text" name="title" value="{{ $currentOrg->title }}" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs">
        @endcomponent

        @component('admin.site-settings._setting-item', [
            'id' => 'tagline',
            'icon' => 'bi-quote',
            'title' => 'Tagline',
            'hint' => 'Short line under the company name.',
        ])
            <input type="text" name="tagline" value="{{ $currentOrg->tagline }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs">
            <div class="flex flex-wrap gap-x-4 gap-y-2 mt-3">
                <input type="hidden" name="theme[show_brand_text]" value="0">
                <label class="flex items-center gap-2 text-[11px] font-semibold text-slate-600">
                    <input type="checkbox" name="theme[show_brand_text]" value="1" {{ !empty($theme['show_brand_text']) ? 'checked' : '' }} class="rounded text-brand-600"> Show name in header
                </label>
                <input type="hidden" name="theme[show_tagline]" value="0">
                <label class="flex items-center gap-2 text-[11px] font-semibold text-slate-600">
                    <input type="checkbox" name="theme[show_tagline]" value="1" {{ !empty($theme['show_tagline']) ? 'checked' : '' }} class="rounded text-brand-600"> Show tagline in header
                </label>
            </div>
        @endcomponent

        @component('admin.site-settings._setting-item', ['id' => 'logo', 'icon' => 'bi-image', 'title' => 'Logo'])
            @if($logoUrl)
                <img src="{{ $logoUrl }}" alt="" class="h-9 w-auto object-contain mb-2">
            @endif
            <input type="file" name="logo" accept="image/*" class="w-full text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700">
            <input type="hidden" name="theme[show_header_logo]" value="0">
            <label class="flex items-center gap-2 text-[11px] font-semibold text-slate-600 mt-3">
                <input type="checkbox" name="theme[show_header_logo]" value="1" {{ !empty($theme['show_header_logo']) ? 'checked' : '' }} class="rounded text-brand-600"> Show logo in header
            </label>
        @endcomponent

        @component('admin.site-settings._setting-item', [
            'id' => 'header-cta',
            'icon' => 'bi-cursor-fill',
            'title' => 'Get in touch button',
            'hint' => 'Call-to-action in the top-right of the header.',
        ])
            <input type="hidden" name="theme[show_header_cta]" value="0">
            <label class="flex items-center gap-2 text-[11px] font-semibold text-slate-600 mb-3">
                <input type="checkbox" name="theme[show_header_cta]" value="1" {{ !empty($theme['show_header_cta']) ? 'checked' : '' }} class="rounded text-brand-600"> Show button
            </label>
            <div class="grid grid-cols-1 gap-2">
                <input type="text" name="theme[header_cta_text]" value="{{ $theme['header_cta_text'] ?? 'Get in touch' }}" placeholder="Button text" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs">
                <input type="text" name="theme[header_cta_url]" value="{{ $theme['header_cta_url'] ?? '/contact' }}" placeholder="/contact" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-mono">
            </div>
        @endcomponent

        @include('admin.site-settings._section-label', ['id' => 'navigation', 'label' => 'Navigation'])

        @component('admin.site-settings._setting-item', [
            'id' => 'navigation',
            'icon' => 'bi-list-ul',
            'title' => 'Navigation links',
            'hint' => 'Every link appears in the header. Choose whether it also shows in the footer Explore column.',
        ])
            @include('admin.site-pages._nav-links', ['bare' => true])
        @endcomponent

        @include('admin.site-settings._section-label', ['id' => 'footer', 'label' => 'Footer'])

        @component('admin.site-settings._setting-item', [
            'id' => 'social',
            'icon' => 'bi-share',
            'title' => 'Social icons',
            'hint' => 'Facebook, LinkedIn, X, etc. under the footer logo.',
        ])
            @include('admin.site-pages._social-links', ['bare' => true])
        @endcomponent

        @component('admin.site-settings._setting-item', [
            'id' => 'contact',
            'icon' => 'bi-envelope',
            'title' => 'Contact details',
            'hint' => 'Footer Contact column.',
        ])
            <div class="space-y-2" x-data="{
                emails: @json($contactEmails->values()->all()),
                phones: @json($contactPhones->values()->all()),
                addEmail() { this.emails.push(''); },
                addPhone() { this.phones.push(''); }
            }">
                <template x-for="(email, i) in emails" :key="'email-'+i">
                    <div class="flex gap-2">
                        <input type="email" :name="'contact_emails['+i+']'" x-model="emails[i]" placeholder="Email address" class="flex-1 px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs">
                        <button type="button" @click="emails.splice(i, 1)" x-show="emails.length > 1" class="px-2 text-rose-500"><i class="bi bi-x-lg"></i></button>
                    </div>
                </template>
                <button type="button" @click="addEmail()" class="text-[11px] font-bold text-brand-700">+ Add email</button>

                <template x-for="(phone, i) in phones" :key="'phone-'+i">
                    <div class="flex gap-2 mt-2">
                        <input type="text" :name="'contact_phones['+i+']'" x-model="phones[i]" placeholder="Phone number" class="flex-1 px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs">
                        <button type="button" @click="phones.splice(i, 1)" x-show="phones.length > 1" class="px-2 text-rose-500"><i class="bi bi-x-lg"></i></button>
                    </div>
                </template>
                <button type="button" @click="addPhone()" class="text-[11px] font-bold text-brand-700">+ Add phone</button>

                <textarea name="address" rows="2" placeholder="Street address" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs mt-2">{{ $currentOrg->address }}</textarea>
                <input type="text" name="po_box" value="{{ $currentOrg->po_box }}" placeholder="P.O. Box" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs">
            </div>
        @endcomponent

        @component('admin.site-settings._setting-item', [
            'id' => 'footer-display',
            'icon' => 'bi-toggles',
            'title' => 'Footer visibility',
            'hint' => 'Show or hide footer areas.',
        ])
            <div class="grid grid-cols-1 gap-2">
                @foreach([
                    'show_footer_tagline' => 'Tagline under logo',
                    'show_footer_nav' => 'Explore & Connect columns',
                    'show_footer_social' => 'Social icons',
                    'show_footer_contact' => 'Contact block',
                    'show_footer_credit' => 'Developer credit',
                ] as $key => $label)
                    <input type="hidden" name="theme[{{ $key }}]" value="0">
                    <label class="flex items-center gap-2 text-[11px] font-semibold text-slate-600">
                        <input type="checkbox" name="theme[{{ $key }}]" value="1" {{ !empty($theme[$key]) ? 'checked' : '' }} class="rounded text-brand-600">
                        {{ $label }}
                    </label>
                @endforeach
            </div>
        @endcomponent

        @include('admin.site-settings._section-label', ['id' => 'branding', 'label' => 'Colors'])

        @component('admin.site-settings._setting-item', [
            'id' => 'branding',
            'icon' => 'bi-palette',
            'title' => 'Site colors',
            'hint' => 'Quick accent and background colors.',
        ])
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 mb-1">Accent</label>
                    <input type="color" name="theme[accent]" value="{{ $theme['accent'] ?? '#0f766e' }}" class="w-full h-9 rounded-lg border border-slate-200 cursor-pointer">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-500 mb-1">Background</label>
                    <input type="color" name="theme[bg]" value="{{ $theme['bg'] ?? '#f3f6f5' }}" class="w-full h-9 rounded-lg border border-slate-200 cursor-pointer">
                </div>
            </div>
            <a href="{{ route('admin.organizations.edit', $currentOrg) }}" class="inline-block mt-2 text-[11px] font-bold text-brand-700 hover:underline">Full Brand & Styling settings →</a>
        @endcomponent

        <div class="sticky bottom-0 pt-4 pb-1 bg-gradient-to-t from-slate-50 via-slate-50 to-transparent">
            <button type="submit" class="w-full px-4 py-3 bg-brand-600 hover:bg-brand-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-brand-600/30">Save site settings</button>
        </div>
    </form>
</div>
@endsection
