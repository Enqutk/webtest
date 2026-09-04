@extends('admin.site-pages.layout')

@section('title', 'Site Settings')
@section('page-title', 'Site Settings')
@section('page-subtitle', $currentOrg->title)

@section('page-form')
@php
    $contactEmail = $contacts->get('email')?->first()?->value ?? '';
    $contactPhone = $contacts->get('phone')?->first()?->value ?? '';
@endphp

<div x-data="{
    activeTab: window.location.hash.replace('#', '') || 'header',
    setTab(tab) {
        this.activeTab = tab;
        history.replaceState(null, '', '#' + tab);
    }
}" x-init="
    if (window.location.hash) activeTab = window.location.hash.replace('#', '');
    window.addEventListener('hashchange', () => { activeTab = window.location.hash.replace('#', '') || 'header'; });
">
    <div class="flex flex-wrap gap-1.5 p-1 bg-slate-100 rounded-xl mb-4">
        @foreach(['header' => 'Header', 'navigation' => 'Navigation', 'footer' => 'Footer', 'branding' => 'Branding'] as $key => $label)
            <button type="button" @click="setTab('{{ $key }}')"
                :class="activeTab === '{{ $key }}' ? 'bg-white text-brand-700 shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                class="px-3 py-1.5 rounded-lg text-xs font-bold transition">{{ $label }}</button>
        @endforeach
    </div>

    <form action="{{ route('admin.site-settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <input type="hidden" name="_tab" :value="activeTab">

        {{-- Header --}}
        <div x-show="activeTab === 'header'" class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm space-y-4" x-cloak>
            <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3">Header & brand bar</h3>
            <p class="text-xs text-slate-500">Shown at the top of every page — logo, name, tagline, and the Get in touch button.</p>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Site / company name</label>
                <input type="text" name="title" value="{{ $currentOrg->title }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
            </div>
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Tagline</label>
                <input type="text" name="tagline" value="{{ $currentOrg->tagline }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
            </div>
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Logo</label>
                @if($logoUrl)
                    <img src="{{ $logoUrl }}" alt="" class="h-10 w-auto object-contain mb-2">
                @endif
                <input type="file" name="logo" accept="image/*" class="w-full text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700">
            </div>

            <div class="grid grid-cols-1 gap-2 pt-2">
                @foreach([
                    'show_brand_text' => 'Show company name in header',
                    'show_tagline' => 'Show tagline in header',
                    'show_header_logo' => 'Show logo in header',
                    'show_header_cta' => 'Show “Get in touch” button',
                ] as $key => $label)
                    <input type="hidden" name="theme[{{ $key }}]" value="0">
                    <label class="flex items-center gap-2 text-xs font-semibold text-slate-700">
                        <input type="checkbox" name="theme[{{ $key }}]" value="1" {{ !empty($theme[$key]) ? 'checked' : '' }} class="rounded text-brand-600">
                        {{ $label }}
                    </label>
                @endforeach
            </div>

            <div class="grid grid-cols-1 gap-3 pt-2 border-t border-slate-100">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Button text</label>
                    <input type="text" name="theme[header_cta_text]" value="{{ $theme['header_cta_text'] ?? 'Get in touch' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Button link</label>
                    <input type="text" name="theme[header_cta_url]" value="{{ $theme['header_cta_url'] ?? '/contact' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono">
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div x-show="activeTab === 'footer'" class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm space-y-4" x-cloak>
            <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3">Footer & contact</h3>
            <p class="text-xs text-slate-500">Contact details and footer visibility. Social icons are managed under <a href="{{ route('admin.socials.index') }}" class="text-brand-700 font-bold hover:underline">Social Media Links</a>.</p>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Email</label>
                <input type="email" name="contact_email" value="{{ $contactEmail }}" placeholder="hello@company.com" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
            </div>
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Phone</label>
                <input type="text" name="contact_phone" value="{{ $contactPhone }}" placeholder="+254 700 000 000" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
            </div>
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Address</label>
                <textarea name="address" rows="2" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">{{ $currentOrg->address }}</textarea>
            </div>
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">P.O. Box</label>
                <input type="text" name="po_box" value="{{ $currentOrg->po_box }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
            </div>

            <div class="grid grid-cols-1 gap-2 pt-2 border-t border-slate-100">
                @foreach([
                    'show_footer_tagline' => 'Show tagline in footer',
                    'show_footer_nav' => 'Show Explore / Connect links',
                    'show_footer_social' => 'Show social icons',
                    'show_footer_contact' => 'Show contact block',
                    'show_footer_credit' => 'Show developer credit',
                ] as $key => $label)
                    <input type="hidden" name="theme[{{ $key }}]" value="0">
                    <label class="flex items-center gap-2 text-xs font-semibold text-slate-700">
                        <input type="checkbox" name="theme[{{ $key }}]" value="1" {{ !empty($theme[$key]) ? 'checked' : '' }} class="rounded text-brand-600">
                        {{ $label }}
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Branding --}}
        <div x-show="activeTab === 'branding'" class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm space-y-4" x-cloak>
            <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3">Colors</h3>
            <p class="text-xs text-slate-500">Quick accent color. For full theme presets and fonts, use <a href="{{ route('admin.organizations.edit', $currentOrg) }}" class="text-brand-700 font-bold hover:underline">Brand & Styling Settings</a>.</p>
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Accent color</label>
                    <input type="color" name="theme[accent]" value="{{ $theme['accent'] ?? '#0f766e' }}" class="w-full h-10 rounded-lg border border-slate-200 cursor-pointer">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Background</label>
                    <input type="color" name="theme[bg]" value="{{ $theme['bg'] ?? '#f3f6f5' }}" class="w-full h-10 rounded-lg border border-slate-200 cursor-pointer">
                </div>
            </div>
        </div>

        <div x-show="activeTab !== 'navigation'">
            <button type="submit" class="w-full px-4 py-3 bg-brand-600 hover:bg-brand-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-brand-600/30">Save site settings</button>
        </div>
    </form>

    <div x-show="activeTab === 'navigation'" x-cloak>
        @include('admin.site-pages._nav-links')
    </div>
</div>
@endsection
