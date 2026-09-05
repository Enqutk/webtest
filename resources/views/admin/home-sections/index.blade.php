@extends('admin.layouts.app')

@section('title', 'Home Page Sections')
@section('page-title', 'Home Page Visual Builder')
@section('page-subtitle', $currentOrg->title)

@push('styles')
<style>
    /* Side-by-side builder: forms left, live preview right (works inside admin sidebar layout) */
    .home-builder-shell {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        width: 100%;
    }
    @media (min-width: 768px) {
        .home-builder-shell {
            flex-direction: row;
            align-items: flex-start;
            gap: 1.5rem;
        }
        .home-builder-editor {
            flex: 0 0 38%;
            width: 38%;
            max-width: 38%;
            min-width: 0;
        }
        .home-builder-preview {
            flex: 1 1 62%;
            width: 62%;
            min-width: 0;
            position: sticky;
            top: 0.75rem;
            align-self: flex-start;
        }
    }
    @media (min-width: 1280px) {
        .home-builder-editor {
            flex-basis: 32%;
            width: 32%;
            max-width: 32%;
        }
        .home-builder-preview {
            flex-basis: 68%;
            width: 68%;
        }
    }
    @media (min-width: 1536px) {
        .home-builder-editor {
            flex-basis: 30%;
            width: 30%;
            max-width: 30%;
        }
        .home-builder-preview {
            flex-basis: 70%;
            width: 70%;
        }
    }
</style>
@endpush

@section('content')
@php
    $liveHomeUrl = route('card.home', ['slug' => $currentOrg->slug, 'admin_preview' => 1]);
    $liveHomeOpenUrl = route('card.home', ['slug' => $currentOrg->slug]);
@endphp

@php
    $hero = $sections['hero'] ?? \App\Models\Organization::defaultHomeSections()['hero'];
    $about = $sections['about'] ?? \App\Models\Organization::defaultHomeSections()['about'];
    $servicesSec = $sections['services'] ?? \App\Models\Organization::defaultHomeSections()['services'];
    $statsSec = $sections['stats'] ?? \App\Models\Organization::defaultHomeSections()['stats'];
    $portfolioSec = $sections['portfolio'] ?? \App\Models\Organization::defaultHomeSections()['portfolio'];
    $clientsSec = $sections['clients'] ?? \App\Models\Organization::defaultHomeSections()['clients'];
    $teamSec = $sections['team'] ?? \App\Models\Organization::defaultHomeSections()['team'];
    $ctaSec = $sections['cta'] ?? \App\Models\Organization::defaultHomeSections()['cta'];
    $creatorSec = $sections['creator'] ?? \App\Models\Organization::defaultHomeSections()['creator'];

    $heroSlides = $hero['slides'] ?? \App\Models\Organization::defaultHeroSlides();
    $sectionLabels = [
        'creator' => 'Creator Bar',
        'hero' => 'Hero Banner',
        'about' => 'About & Mission',
        'services' => 'Services Section',
        'stats' => 'Impact & Stats',
        'portfolio' => 'Portfolio Section',
        'team' => 'Leadership Team',
        'clients' => 'Clients & Partners',
        'cta' => 'CTA Banner',
    ];
@endphp

<div class="space-y-6" x-data="homeSectionsBuilder">

    <!-- Active Organization Banner & Fast Switcher -->
    <div class="bg-gradient-to-r from-brand-500/10 via-amber-500/10 to-brand-500/5 border border-brand-200 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-brand-600 text-white flex items-center justify-center font-bold text-sm shadow-md shadow-brand-500/20 shrink-0 overflow-hidden">
                @if($currentOrg->getFirstMediaUrl('logo'))
                    <img src="{{ $currentOrg->getFirstMediaUrl('logo') }}" alt="logo" class="w-full h-full object-cover">
                @else
                    {{ mb_substr($currentOrg->title, 0, 2) }}
                @endif
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-brand-700 bg-brand-100 px-2 py-0.5 rounded-md">Selected Organization</span>
                    <span class="text-xs font-mono text-slate-400">/{{ $currentOrg->slug }}</span>
                </div>
                <h2 class="text-base font-bold text-slate-900 leading-tight mt-0.5">{{ $currentOrg->title }}</h2>
            </div>
        </div>

        <!-- Switch Organization Dropdown -->
        <div class="flex items-center gap-2 shrink-0" x-data="{ openOrgDropdown: false }">
            <span class="text-xs text-slate-500 font-semibold hidden md:inline">Change Organization:</span>
            <div class="relative">
                <button @click="openOrgDropdown = !openOrgDropdown" type="button" class="px-3.5 py-2 bg-white border border-slate-200 hover:border-brand-500 rounded-xl text-xs font-bold text-slate-800 shadow-sm flex items-center gap-2 transition">
                    <i class="bi bi-buildings text-brand-600"></i>
                    <span class="max-w-[160px] truncate">{{ $currentOrg->title }}</span>
                    <i class="bi bi-chevron-down text-[10px] text-slate-400"></i>
                </button>

                <div x-show="openOrgDropdown" @click.away="openOrgDropdown = false" x-transition class="absolute right-0 mt-1.5 w-64 bg-white border border-slate-200 rounded-xl shadow-xl p-1.5 z-50 space-y-1" x-cloak>
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-2 py-1">Select Organization to Adjust:</div>
                    @foreach(\App\Models\Organization::all() as $orgOption)
                        <a href="{{ route('admin.home-sections.index', ['org' => $orgOption->id]) }}" class="block px-2.5 py-2 rounded-lg text-xs font-semibold {{ $orgOption->id === $currentOrg->id ? 'bg-brand-50 text-brand-700 font-bold' : 'hover:bg-slate-50 text-slate-700' }}">
                            <div class="flex items-center justify-between">
                                <span class="truncate">{{ $orgOption->title }}</span>
                                @if($orgOption->id === $currentOrg->id)
                                    <i class="bi bi-check2 text-brand-600"></i>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Top Section Switcher Navigation -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-2 shadow-sm flex flex-wrap gap-1.5 sticky top-2 z-20 backdrop-blur-md bg-white/95">
        <button type="button" @click="selectSection('creator')" :class="activeSection === 'creator' ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2">
            <span>Creator {{ !empty($creatorSec['is_visible']) ? 'ON' : 'OFF' }}</span>
        </button>
        <button type="button" @click="selectSection('hero')" :class="activeSection === 'hero' ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2">
            <span>Hero ({{ count($heroSlides) }})</span>
        </button>
        <button type="button" @click="selectSection('about')" :class="activeSection === 'about' ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2">
            <span>About</span>
        </button>
        <button type="button" @click="selectSection('services')" :class="activeSection === 'services' ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2">
            <span>Services ({{ $services->count() }})</span>
        </button>
        <button type="button" @click="selectSection('stats')" :class="activeSection === 'stats' ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2">
            <span>Impact & Stats ({{ count($statsItems) }})</span>
        </button>
        <button type="button" @click="selectSection('portfolio')" :class="activeSection === 'portfolio' ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2">
            <span>Portfolio</span>
        </button>
        <button type="button" @click="selectSection('team')" :class="activeSection === 'team' ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2">
            <span>Team ({{ $teamMembers->count() }})</span>
        </button>
        <button type="button" @click="selectSection('clients')" :class="activeSection === 'clients' ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2">
            <span>Clients</span>
        </button>
        <button type="button" @click="selectSection('cta')" :class="activeSection === 'cta' ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2">
            <span>CTA</span>
        </button>
    </div>

    <div class="home-builder-shell">
        <!-- LEFT: forms -->
        <div class="home-builder-editor space-y-6">

    <!-- ✨ SECTION 0: CREATOR BAR -->
    <div id="admin-form-creator" x-show="activeSection === 'creator'" class="space-y-6" x-cloak>
        <form action="{{ route('admin.home-sections.update') }}" method="POST" class="bg-white rounded-2xl border border-slate-200/80 p-6 lg:p-8 shadow-sm space-y-6">
            @csrf
            <input type="hidden" name="section" value="creator">
            <input type="hidden" name="is_visible" value="0">

            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Creator of this platform</h3>
                    <p class="text-xs text-slate-500">Thin credit bar under the header. Turn it ON or OFF, then edit the wording.</p>
                </div>
                <label class="flex items-center gap-2 text-xs font-bold text-slate-700 cursor-pointer">
                    <input type="checkbox" name="is_visible" value="1" x-model="creatorVisible" {{ !empty($creatorSec['is_visible']) ? 'checked' : '' }} class="w-4 h-4 rounded text-brand-600">
                    <span x-text="creatorVisible ? 'Show Creator Bar ON' : 'Show Creator Bar OFF'"></span>
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Label</label>
                    <input type="text" name="label" x-model="creatorLabel" value="{{ $creatorSec['label'] ?? 'Creator of this platform' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Name</label>
                    <input type="text" name="name" x-model="creatorName" value="{{ $creatorSec['name'] ?? '' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Supporting line</label>
                <input type="text" name="line" x-model="creatorLine" value="{{ $creatorSec['line'] ?? '' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Button text</label>
                    <input type="text" name="cta_text" x-model="creatorCtaText" value="{{ $creatorSec['cta_text'] ?? '' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Button link</label>
                    <input type="text" name="url" value="{{ $creatorSec['url'] ?? '/' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                    <p class="text-[11px] text-slate-400">Use <code>/</code> for the Kimem landing page, or a full URL.</p>
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30 transition">
                    Save Creator Bar
                </button>
            </div>
        </form>
    </div>

    <!-- 🌟 SECTION 1: HERO BANNER & SLIDES -->
    <div id="admin-form-hero" x-show="activeSection === 'hero'" class="space-y-6">
        <!-- Banner Settings Form -->
        <form action="{{ route('admin.home-sections.update') }}" method="POST" class="bg-white rounded-2xl border border-slate-200/80 p-6 lg:p-8 shadow-sm space-y-6">
            @csrf
            <input type="hidden" name="section" value="hero">

            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Hero Banner Global Headlines & Actions</h3>
                    <p class="text-xs text-slate-500">Configure top hero category badge, main headline, and action button links.</p>
                </div>
                <label class="flex items-center gap-2 text-xs font-bold text-slate-700 cursor-pointer">
                    <input type="checkbox" name="is_visible" value="1" {{ !empty($hero['is_visible']) ? 'checked' : '' }} class="w-4 h-4 rounded text-brand-600">
                    <span>Show Hero Section ON</span>
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Eyebrow / Badge</label>
                    <input type="text" name="badge" x-model="heroBadge" value="{{ $hero['badge'] ?? 'Infrastructure · Engineering · Impact' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Category / Subtitle</label>
                    <input type="text" name="subtitle" x-model="heroSubtitle" value="{{ $hero['subtitle'] ?? 'Engineering Excellence' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Hero Photo Shape Preset</label>
                    <select name="image_shape" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                        @foreach($shapeOptions as $k => $n)
                            <option value="{{ $k }}" {{ ($hero['image_shape'] ?? 'inherit') === $k ? 'selected' : '' }}>{{ $n }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Main Headline <span class="text-rose-500">*</span></label>
                <input type="text" name="title" x-model="heroTitle" value="{{ $hero['title'] ?? 'Building resilient infrastructure for lasting communities' }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:bg-white transition">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Supporting Description</label>
                <textarea name="description" x-model="heroDescription" rows="2" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">{{ $hero['description'] ?? '' }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-100">
                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Primary Button Text</label>
                        <input type="text" name="cta_text" x-model="heroCtaText" value="{{ $hero['cta_text'] ?? 'Explore Our Work' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Primary Link</label>
                        <input type="text" name="cta_url" value="{{ $hero['cta_url'] ?? '/portfolio' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Secondary Button Text</label>
                        <input type="text" name="secondary_cta_text" x-model="heroSecondaryCtaText" value="{{ $hero['secondary_cta_text'] ?? 'Our Services' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Secondary Link</label>
                        <input type="text" name="secondary_cta_url" value="{{ $hero['secondary_cta_url'] ?? '/our-services' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30 transition">
                    Save Hero Banner Settings
                </button>
            </div>
        </form>

        <!-- Carousel Slides List Card -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 lg:p-8 shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Hero Carousel Slides</h3>
                    <p class="text-xs text-slate-500">Add, edit photo, change text, or re-order slides in the homepage hero carousel.</p>
                </div>
                <button type="button" @click="newSlide()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl shadow-md shadow-emerald-600/20 transition flex items-center gap-2">
                    <i class="bi bi-plus-circle"></i>
                    <span>Add New Slide</span>
                </button>
            </div>

            <div class="space-y-3">
                @foreach($heroSlides as $idx => $s)
                    @php
                        $imgPath = $s['image_path'] ?? (is_array($s['image'] ?? null) ? array_values($s['image'])[0] : ($s['image'] ?? null));
                        $fullImgUrl = $imgPath ? (str_starts_with($imgPath, 'http') ? $imgPath : asset('storage/' . ltrim($imgPath, '/'))) : null;
                    @endphp
                    <div class="flex items-center justify-between p-3.5 rounded-xl bg-slate-50 hover:bg-slate-100/80 border border-slate-200/80 transition">
                        <div class="flex items-center gap-4 min-w-0">
                            <!-- Thumb -->
                            <div class="w-16 h-16 rounded-xl bg-slate-200 overflow-hidden shrink-0 border border-slate-300 flex items-center justify-center">
                                @if($fullImgUrl)
                                    @php
                                        $thumbFocus = \App\Models\Organization::imageObjectPosition($s['image_focus_x'] ?? null, $s['image_focus_y'] ?? null);
                                    @endphp
                                    <img src="{{ $fullImgUrl }}" alt="slide" class="w-full h-full object-cover" style="object-position: {{ $thumbFocus }};">
                                @else
                                    <i class="bi bi-image text-slate-400 text-xl"></i>
                                @endif
                            </div>

                            <div class="min-w-0 space-y-0.5">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-xs font-bold text-slate-900 truncate">{{ $s['title'] ?? 'Slide #'.($idx+1) }}</span>
                                    @if(!empty($s['image_shape']) && $s['image_shape'] !== 'inherit')
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">
                                            Shape: {{ ucfirst($s['image_shape']) }}
                                        </span>
                                    @endif
                                    @if(isset($s['is_visible']) && !$s['is_visible'])
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-200 text-slate-600">Hidden</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Visible</span>
                                    @endif
                                </div>
                                <p class="text-[11px] text-slate-500 truncate max-w-xl">{{ $s['description'] ?? '' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <button type="button" @click="editSlide({{ $idx }}, {{ json_encode($s) }})" class="px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-100 text-xs font-bold rounded-lg transition flex items-center gap-1.5">
                                <i class="bi bi-pencil"></i>
                                <span>Edit</span>
                            </button>
                            <form action="{{ route('admin.home-sections.slides.delete', $idx) }}" method="POST" onsubmit="return confirm('Delete this slide?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-rose-500 hover:bg-rose-50 rounded-lg transition" title="Delete Slide">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- 👥 SECTION 6: LEADERSHIP TEAM -->
    <div id="admin-form-team" x-show="activeSection === 'team'" class="space-y-6" x-cloak>
        <!-- Team Section Header Config -->
        <form action="{{ route('admin.home-sections.update') }}" method="POST" class="bg-white rounded-2xl border border-slate-200/80 p-6 lg:p-8 shadow-sm space-y-6">
            @csrf
            <input type="hidden" name="section" value="team">

            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Leadership Team Showcase Settings</h3>
                    <p class="text-xs text-slate-500">Configure team section heading, bio, button, and headshot photo shape.</p>
                </div>
                <label class="flex items-center gap-2 text-xs font-bold text-slate-700 cursor-pointer">
                    <input type="checkbox" name="is_visible" value="1" {{ !empty($teamSec['is_visible']) ? 'checked' : '' }} class="w-4 h-4 rounded text-brand-600">
                    <span>Show Team Section ON</span>
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Section Eyebrow</label>
                    <input type="text" name="eyebrow" x-model="teamEyebrow" value="{{ $teamSec['eyebrow'] ?? 'Leadership & Team' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Section Heading</label>
                    <input type="text" name="title" x-model="teamTitle" value="{{ $teamSec['title'] ?? 'Experienced engineers & hydrologists' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Team Photo Shape Preset</label>
                    <select name="image_shape" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                        @foreach($shapeOptions as $k => $n)
                            <option value="{{ $k }}" {{ ($teamSec['image_shape'] ?? 'inherit') === $k ? 'selected' : '' }}>{{ $n }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Section Description</label>
                <textarea name="description" x-model="teamDescription" rows="2" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">{{ $teamSec['description'] ?? '' }}</textarea>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30 transition">
                    Save Team Section Settings
                </button>
            </div>
        </form>

        <!-- Team Members List Card with Add/Edit Modal -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 lg:p-8 shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Team Members Displayed on Homepage</h3>
                    <p class="text-xs text-slate-500">Manage member photos, titles, founder badges, and display orders.</p>
                </div>
                <button type="button" @click="newMember()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl shadow-md shadow-emerald-600/20 transition flex items-center gap-2">
                    <i class="bi bi-person-plus-fill"></i>
                    <span>Add Team Member</span>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($teamMembers as $m)
                    @php
                        $photoUrl = $m->getFirstMediaUrl('team-images');
                    @endphp
                    <div class="flex items-center justify-between p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                        <div class="flex items-center gap-3.5 min-w-0">
                            <div class="w-14 h-14 rounded-xl bg-slate-200 overflow-hidden shrink-0 border border-slate-300 flex items-center justify-center">
                                @if($photoUrl)
                                    <img src="{{ $photoUrl }}" alt="{{ $m->full_name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-sm font-bold text-slate-400">{{ mb_substr($m->first_name, 0, 1) }}</span>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold text-slate-900">{{ $m->full_name }}</span>
                                    @if($m->founder)
                                        <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800">FOUNDER</span>
                                    @endif
                                </div>
                                <span class="text-[11px] text-brand-600 font-semibold block">{{ $m->title }}</span>
                                <span class="text-[10px] text-slate-400">Order: {{ $m->order }} &bull; Status: {{ ucfirst($m->status->value ?? 'active') }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <button type="button" @click="editMember({{ json_encode(array_merge($m->only(['id','first_name','last_name','title','description','order','founder','image_focus_x','image_focus_y']), ['status' => $m->status->value ?? $m->status, 'image_url' => $m->getFirstMediaUrl('team-images') ?: ''])) }})" class="px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-100 text-xs font-bold rounded-lg transition">
                                Edit
                            </button>
                            <form action="{{ route('admin.team.destroy', $m) }}" method="POST" onsubmit="return confirm('Delete this team member?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-rose-500 hover:bg-rose-50 rounded-lg transition">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- 🏛️ SECTION 2: ABOUT SECTION -->
    <div id="admin-form-about" x-show="activeSection === 'about'" class="space-y-6" x-cloak>
        <form action="{{ route('admin.home-sections.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl border border-slate-200/80 p-6 lg:p-8 shadow-sm space-y-6">
            @csrf
            <input type="hidden" name="section" value="about">

            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">About & Mission Section</h3>
                    <p class="text-xs text-slate-500">Configure company background, highlights, feature blocks, and photo shape.</p>
                </div>
                <label class="flex items-center gap-2 text-xs font-bold text-slate-700 cursor-pointer">
                    <input type="checkbox" name="is_visible" value="1" {{ !empty($about['is_visible']) ? 'checked' : '' }} class="w-4 h-4 rounded text-brand-600">
                    <span>Show About Section ON</span>
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Eyebrow</label>
                    <input type="text" name="eyebrow" x-model="aboutEyebrow" value="{{ $about['eyebrow'] ?? 'About our firm' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Headline</label>
                    <input type="text" name="title" x-model="aboutTitle" value="{{ $about['title'] ?? 'Rooted in East Africa, built for scale' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">About Photo Shape Preset</label>
                    <select name="image_shape" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                        @foreach($shapeOptions as $k => $n)
                            <option value="{{ $k }}" {{ ($about['image_shape'] ?? 'inherit') === $k ? 'selected' : '' }}>{{ $n }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Paragraph 1</label>
                <textarea name="paragraph_1" x-model="aboutP1" rows="2" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">{{ $about['paragraph_1'] ?? '' }}</textarea>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Paragraph 2</label>
                <textarea name="paragraph_2" x-model="aboutP2" rows="2" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">{{ $about['paragraph_2'] ?? '' }}</textarea>
            </div>

            <div class="pt-4 border-t border-slate-100 space-y-3">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Feature highlights</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5">The four cards under the about text (Field-first design, etc.).</p>
                    </div>
                    <button type="button" @click="aboutPoints.push({ title: '', description: '', icon: 'bi bi-compass' })" class="text-[11px] font-bold text-brand-700">+ Add feature</button>
                </div>

                <div class="space-y-3">
                    <template x-for="(point, i) in aboutPoints" :key="'about-point-'+i">
                        <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/80 space-y-3" :id="'about-point-' + i">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] font-bold text-slate-600" x-text="'Feature ' + (i + 1)"></span>
                                <button type="button" @click="aboutPoints.splice(i, 1)" x-show="aboutPoints.length > 1" class="text-rose-500 text-xs"><i class="bi bi-trash"></i></button>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-slate-700">Title</label>
                                    <input type="text" :id="'about-point-' + i + '-title'" :name="'points['+i+'][title]'" x-model="aboutPoints[i].title" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-slate-700">Icon</label>
                                    <select :name="'points['+i+'][icon]'" x-model="aboutPoints[i].icon" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs">
                                        <option value="bi bi-compass">Compass</option>
                                        <option value="bi bi-hammer">Hammer</option>
                                        <option value="bi bi-cloud-sun">Cloud / sun</option>
                                        <option value="bi bi-people">People</option>
                                        <option value="bi bi-shield-check">Shield</option>
                                        <option value="bi bi-globe">Globe</option>
                                        <option value="bi bi-check-lg">Check</option>
                                    </select>
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-slate-700">Description</label>
                                <textarea :name="'points['+i+'][description]'" x-model="aboutPoints[i].description" rows="2" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs"></textarea>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30 transition">
                    Save About Settings
                </button>
            </div>
        </form>
    </div>

    <!-- 🔧 SECTION 3: SERVICES SECTION -->
    <div id="admin-form-services" x-show="activeSection === 'services'" class="space-y-6" x-cloak>
        <form action="{{ route('admin.home-sections.update') }}" method="POST" class="bg-white rounded-2xl border border-slate-200/80 p-6 lg:p-8 shadow-sm space-y-6">
            @csrf
            <input type="hidden" name="section" value="services">

            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Services Section Headlines</h3>
                    <p class="text-xs text-slate-500">Configure services section titles and CTA button text.</p>
                </div>
                <label class="flex items-center gap-2 text-xs font-bold text-slate-700 cursor-pointer">
                    <input type="checkbox" name="is_visible" value="1" {{ !empty($servicesSec['is_visible']) ? 'checked' : '' }} class="w-4 h-4 rounded text-brand-600">
                    <span>Show Services Section ON</span>
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Eyebrow</label>
                    <input type="text" name="eyebrow" x-model="servicesEyebrow" value="{{ $servicesSec['eyebrow'] ?? 'Core Capabilities' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Heading</label>
                    <input type="text" name="title" x-model="servicesTitle" value="{{ $servicesSec['title'] ?? 'Integrated solutions for complex infrastructure' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Description</label>
                <textarea name="description" x-model="servicesDescription" rows="2" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">{{ $servicesSec['description'] ?? '' }}</textarea>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30 transition">
                    Save Services Settings
                </button>
            </div>
        </form>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 lg:p-8 shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Service cards on homepage</h3>
                    <p class="text-xs text-slate-500">Solar drip, Rural WASH, and other offerings shown in the services grid.</p>
                </div>
                <button type="button" @click="newService()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl shadow-md shadow-emerald-600/20 transition flex items-center gap-2">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span>Add Service</span>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($services as $srv)
                    @php $img = $srv->main_image_url; @endphp
                    <div id="service-{{ $srv->id }}" class="flex items-center justify-between p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                        <div class="flex items-center gap-3.5 min-w-0">
                            <div class="w-14 h-14 rounded-xl bg-slate-200 overflow-hidden shrink-0 border border-slate-300 flex items-center justify-center">
                                @if($img)
                                    <img src="{{ $img }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <i class="bi bi-wrench text-slate-400"></i>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold text-slate-900 truncate">{{ $srv->title }}</span>
                                    <span class="px-1.5 py-0.5 rounded text-[10px] font-bold {{ $srv->status === \App\Enums\StatusEnum::active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600' }}">
                                        {{ ucfirst($srv->status->value ?? 'active') }}
                                    </span>
                                </div>
                                <p class="text-[11px] text-slate-500 line-clamp-2 mt-0.5">{{ $srv->short_description }}</p>
                                <span class="text-[10px] text-slate-400">Order: {{ $srv->order }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <button type="button" @click="editService({{ json_encode([
                                'id' => $srv->id,
                                'title' => $srv->title,
                                'short_description' => $srv->short_description,
                                'quote' => $srv->quote,
                                'order' => $srv->order,
                                'status' => $srv->status->value ?? $srv->status,
                            ]) }})" class="px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-100 text-xs font-bold rounded-lg transition">
                                Edit
                            </button>
                            <form action="{{ route('admin.services.destroy', $srv) }}" method="POST" onsubmit="return confirm('Delete this service?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-rose-500 hover:bg-rose-50 rounded-lg transition">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- 📈 SECTION 4: STATS SECTION -->
    <div id="admin-form-stats" x-show="activeSection === 'stats'" class="space-y-6" x-cloak>
        <form action="{{ route('admin.home-sections.update') }}" method="POST" class="bg-white rounded-2xl border border-slate-200/80 p-6 lg:p-8 shadow-sm space-y-6">
            @csrf
            <input type="hidden" name="section" value="stats">

            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Impact & Statistics Section</h3>
                    <p class="text-xs text-slate-500">Configure key metric numbers and achievements.</p>
                </div>
                <label class="flex items-center gap-2 text-xs font-bold text-slate-700 cursor-pointer">
                    <input type="checkbox" name="is_visible" value="1" {{ !empty($statsSec['is_visible']) ? 'checked' : '' }} class="w-4 h-4 rounded text-brand-600">
                    <span>Show Stats Section ON</span>
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Eyebrow</label>
                    <input type="text" name="eyebrow" x-model="statsEyebrow" value="{{ $statsSec['eyebrow'] ?? 'By the numbers' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Section Heading</label>
                    <input type="text" name="title" x-model="statsTitle" value="{{ $statsSec['title'] ?? 'Impact that compounds across communities' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 space-y-3">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Impact numbers</h4>
                        <p class="text-[11px] text-slate-500 mt-0.5">The metrics shown in the dark stats row (25+, Counties served, etc.).</p>
                    </div>
                    <button type="button" @click="statsItems.push({ value: '', label: '' })" class="text-[11px] font-bold text-brand-700">+ Add stat</button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <template x-for="(stat, i) in statsItems" :key="'stat-item-'+i">
                        <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/80 space-y-3" :id="'stat-' + i">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] font-bold text-slate-600" x-text="'Stat ' + (i + 1)"></span>
                                <button type="button" @click="statsItems.splice(i, 1)" x-show="statsItems.length > 1" class="text-rose-500 text-xs"><i class="bi bi-trash"></i></button>
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-slate-700">Value</label>
                                <input type="text" :id="'stat-' + i + '-value'" :name="'items['+i+'][value]'" x-model="statsItems[i].value" placeholder="e.g. 25+ or 140k+" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold">
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-slate-700">Label</label>
                                <input type="text" :id="'stat-' + i + '-label'" :name="'items['+i+'][label]'" x-model="statsItems[i].label" placeholder="e.g. Counties served" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs">
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30 transition">
                    Save Stats Settings
                </button>
            </div>
        </form>
    </div>

    <!-- 💼 SECTION 5: PORTFOLIO SECTION -->
    <div id="admin-form-portfolio" x-show="activeSection === 'portfolio'" class="space-y-6" x-cloak>
        <form action="{{ route('admin.home-sections.update') }}" method="POST" class="bg-white rounded-2xl border border-slate-200/80 p-6 lg:p-8 shadow-sm space-y-6">
            @csrf
            <input type="hidden" name="section" value="portfolio">

            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Portfolio & Projects Section</h3>
                    <p class="text-xs text-slate-500">Configure project gallery headlines, button links, and photo shape style.</p>
                </div>
                <label class="flex items-center gap-2 text-xs font-bold text-slate-700 cursor-pointer">
                    <input type="checkbox" name="is_visible" value="1" {{ !empty($portfolioSec['is_visible']) ? 'checked' : '' }} class="w-4 h-4 rounded text-brand-600">
                    <span>Show Portfolio Section ON</span>
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Eyebrow</label>
                    <input type="text" name="eyebrow" x-model="portfolioEyebrow" value="{{ $portfolioSec['eyebrow'] ?? 'Featured Projects' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Heading</label>
                    <input type="text" name="title" x-model="portfolioTitle" value="{{ $portfolioSec['title'] ?? 'Delivering resilient infrastructure across East Africa' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Project Card Photo Shape Preset</label>
                    <select name="image_shape" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                        @foreach($shapeOptions as $k => $n)
                            <option value="{{ $k }}" {{ ($portfolioSec['image_shape'] ?? 'inherit') === $k ? 'selected' : '' }}>{{ $n }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30 transition">
                    Save Portfolio Settings
                </button>
            </div>
        </form>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 lg:p-8 shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Project cards on homepage</h3>
                    <p class="text-xs text-slate-500">Rift Valley Solar Drip Pilot and other case studies in the portfolio grid.</p>
                </div>
                <button type="button" @click="newProject()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl shadow-md shadow-emerald-600/20 transition flex items-center gap-2">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span>Add project</span>
                </button>
            </div>

            <div class="grid grid-cols-1 gap-4">
                @foreach($projects as $project)
                    @php $img = $project->getFirstMediaUrl('image'); @endphp
                    <div id="project-{{ $project->id }}" class="flex items-center justify-between p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                        <div class="flex items-center gap-3.5 min-w-0">
                            <div class="w-14 h-14 rounded-xl bg-slate-200 overflow-hidden shrink-0 border border-slate-300 flex items-center justify-center">
                                @if($img)
                                    <img src="{{ $img }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <i class="bi bi-briefcase text-slate-400"></i>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-bold text-slate-900 truncate">{{ $project->name }}</span>
                                    @if($project->category)
                                        <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-brand-50 text-brand-700">{{ $project->category }}</span>
                                    @endif
                                </div>
                                <p class="text-[11px] text-slate-500 line-clamp-2 mt-0.5">{{ $project->description }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <button type="button" @click="editProject({{ json_encode([
                                'id' => $project->id,
                                'name' => $project->name,
                                'category' => $project->category,
                                'link' => $project->link,
                                'description' => $project->description,
                                'order' => $project->order,
                                'status' => $project->status->value ?? $project->status,
                            ]) }})" class="px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-100 text-xs font-bold rounded-lg transition">Edit</button>
                            <form action="{{ route('admin.portfolio.destroy', $project) }}" method="POST" onsubmit="return confirm('Delete this project?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-rose-500 hover:bg-rose-50 rounded-lg transition"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- 🤝 SECTION: CLIENTS -->
    <div id="admin-form-clients" x-show="activeSection === 'clients'" class="space-y-6" x-cloak>
        <form action="{{ route('admin.home-sections.update') }}" method="POST" class="bg-white rounded-2xl border border-slate-200/80 p-6 lg:p-8 shadow-sm space-y-6">
            @csrf
            <input type="hidden" name="section" value="clients">

            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Clients & Partners Section</h3>
                    <p class="text-xs text-slate-500">Section headlines plus individual client and partner logos below.</p>
                </div>
                <label class="flex items-center gap-2 text-xs font-bold text-slate-700 cursor-pointer">
                    <input type="checkbox" name="is_visible" value="1" {{ !empty($clientsSec['is_visible']) ? 'checked' : '' }} class="w-4 h-4 rounded text-brand-600">
                    <span>Show Clients Section ON</span>
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Eyebrow</label>
                    <input type="text" name="eyebrow" x-model="clientsEyebrow" value="{{ $clientsSec['eyebrow'] ?? 'Trusted partners' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Heading</label>
                    <input type="text" name="title" x-model="clientsTitle" value="{{ $clientsSec['title'] ?? 'Organizations we work alongside' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Description</label>
                <textarea name="description" rows="2" x-model="clientsDescription" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">{{ $clientsSec['description'] ?? '' }}</textarea>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30 transition">
                    Save Clients Settings
                </button>
            </div>
        </form>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 lg:p-8 shadow-sm space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Client & partner logos</h3>
                    <p class="text-xs text-slate-500">East Africa Climate Fund, cooperatives, and other logos shown in the grid.</p>
                </div>
                <button type="button" @click="newClient()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold rounded-xl shadow-md shadow-emerald-600/20 transition flex items-center gap-2">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span>Add logo</span>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($clientPartners as $client)
                    @php $logo = $client->getFirstMediaUrl('image'); @endphp
                    <div id="client-{{ $client->id }}" class="flex items-center justify-between p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-12 h-12 rounded-lg bg-white border border-slate-200 flex items-center justify-center shrink-0 overflow-hidden">
                                @if($logo)
                                    <img src="{{ $logo }}" alt="" class="w-full h-full object-contain p-1">
                                @else
                                    <span class="text-[9px] font-bold text-slate-500 text-center px-1 leading-tight">{{ $client->name }}</span>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <div class="text-xs font-bold text-slate-900 truncate">{{ $client->name }}</div>
                                <span class="text-[10px] font-bold uppercase {{ ($client->type->value ?? $client->type) === 'partner' ? 'text-brand-700' : 'text-slate-500' }}">{{ ucfirst($client->type->value ?? $client->type) }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <button type="button" @click="editClient({{ json_encode([
                                'id' => $client->id,
                                'name' => $client->name,
                                'type' => $client->type->value ?? $client->type,
                                'link' => $client->link,
                                'order' => $client->order,
                                'status' => $client->status->value ?? $client->status,
                            ]) }})" class="px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-100 text-xs font-bold rounded-lg transition">Edit</button>
                            <form action="{{ route('admin.clients.destroy', $client) }}" method="POST" onsubmit="return confirm('Remove this logo?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-rose-500 hover:bg-rose-50 rounded-lg transition"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- 📣 SECTION 7: CTA BANNER -->
    <div id="admin-form-cta" x-show="activeSection === 'cta'" class="space-y-6" x-cloak>
        <form action="{{ route('admin.home-sections.update') }}" method="POST" class="bg-white rounded-2xl border border-slate-200/80 p-6 lg:p-8 shadow-sm space-y-6">
            @csrf
            <input type="hidden" name="section" value="cta">

            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Bottom Call to Action Banner</h3>
                    <p class="text-xs text-slate-500">High-contrast call to action banner shown right above the footer.</p>
                </div>
                <label class="flex items-center gap-2 text-xs font-bold text-slate-700 cursor-pointer">
                    <input type="checkbox" name="is_visible" value="1" {{ !empty($ctaSec['is_visible']) ? 'checked' : '' }} class="w-4 h-4 rounded text-brand-600">
                    <span>Show CTA Banner ON</span>
                </label>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Banner Headline</label>
                    <input type="text" name="title" x-model="ctaTitle" value="{{ $ctaSec['title'] ?? 'Ready to build water infrastructure that lasts?' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Button Text & Link</label>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="text" name="button_text" x-model="ctaButtonText" value="{{ $ctaSec['button_text'] ?? 'Talk to an engineer' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                        <input type="text" name="button_url" value="{{ $ctaSec['button_url'] ?? '/contact' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30 transition">
                    Save CTA Banner Settings
                </button>
            </div>
        </form>
    </div>

        </div><!-- /forms column -->

        <!-- RIGHT: sticky live preview -->
        <aside class="home-builder-preview">
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden h-full">
                <div class="flex items-center justify-between gap-3 p-3 sm:p-4 border-b border-slate-100 bg-slate-50/80">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <i class="bi bi-eye text-brand-600"></i>
                            <span class="text-sm font-bold text-slate-900">Live Preview</span>
                            <span class="px-2 py-0.5 rounded-md bg-brand-50 text-brand-700 text-[11px] font-bold" x-text="sectionLabels[activeSection] || activeSection"></span>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-0.5">Click a section here → form opens on the left.</p>
                    </div>
                    <a href="{{ $liveHomeOpenUrl }}" target="_blank" rel="noopener"
                       class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-lg transition">
                        <i class="bi bi-box-arrow-up-right"></i> Open
                    </a>
                </div>
                <iframe
                    x-ref="previewFrame"
                    src="{{ $liveHomeUrl }}"
                    class="w-full bg-white block"
                    style="height: min(75vh, 780px); border: 0;"
                    loading="eager"
                    referrerpolicy="no-referrer-when-downgrade"
                    @load="onPreviewLoad()"
                ></iframe>
            </div>
        </aside>
    </div><!-- /side-by-side shell -->

    <!-- MODAL 1: ADD / EDIT HERO SLIDE -->
    <div x-show="openSlideModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="min-h-full px-4 py-8 flex items-center justify-center">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="openSlideModal = false"></div>

            <!-- Modal Panel -->
            <div class="relative bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-2xl w-full p-6 lg:p-8 space-y-6 z-10">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <h3 class="text-base font-bold text-slate-900" x-text="editingSlideIndex !== null ? 'Edit Hero Slide' : 'Add New Hero Slide'"></h3>
                    <button @click="openSlideModal = false" class="text-slate-400 hover:text-slate-700"><i class="bi bi-x-lg"></i></button>
                </div>

                <form action="{{ route('admin.home-sections.slides.save') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <input type="hidden" name="slide_index" :value="editingSlideIndex">

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Slide Main Headline <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" x-model="slideTitle" required placeholder="e.g. Water systems that feed people" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Slide Eyebrow / Subtitle</label>
                        <input type="text" name="subtitle" x-model="slideSubtitle" placeholder="e.g. Irrigation &middot; WASH &middot; Resilience" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Short Supporting Story / Copy</label>
                        <textarea name="description" x-model="slideDesc" rows="2" placeholder="Brief 1-2 sentence description" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Button Label</label>
                            <input type="text" name="text_link" x-model="slideBtnText" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Button Link</label>
                            <input type="text" name="button_link" x-model="slideBtnLink" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Slide Photo Shape Preset (Optional Override)</label>
                        <select name="image_shape" x-model="slideShape" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                            @foreach($shapeOptions as $k => $n)
                                <option value="{{ $k }}">{{ $n }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-1.5 pt-2">
                        <label class="block text-xs font-bold text-slate-700">Slide Background Photo</label>
                        <input type="file" name="slide_image" accept="image/*" @change="onSlideImagePick($event)" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                    </div>

                    @include('admin.partials.image-focus-picker', [
                        'focusX' => 'slideFocusX',
                        'focusY' => 'slideFocusY',
                        'previewUrl' => 'slidePreviewUrl',
                    ])

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <label class="flex items-center gap-2 text-xs font-semibold text-slate-700 cursor-pointer">
                            <input type="checkbox" name="is_visible" value="1" x-model="slideVisible" class="w-4 h-4 rounded text-brand-600">
                            <span>Slide Visible</span>
                        </label>

                        <div class="flex items-center gap-3">
                            <button type="button" @click="openSlideModal = false" class="px-4 py-2 bg-slate-100 text-slate-700 text-xs font-bold rounded-xl">Cancel</button>
                            <button type="submit" class="px-5 py-2 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30">Save Slide</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL 2: ADD / EDIT TEAM MEMBER -->
    <div x-show="openTeamModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="min-h-full px-4 py-8 flex items-center justify-center">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="openTeamModal = false"></div>

            <!-- Modal Panel -->
            <div class="relative bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-2xl w-full p-6 lg:p-8 space-y-6 z-10">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <h3 class="text-base font-bold text-slate-900" x-text="editingMemberId !== null ? 'Edit Team Member Profile' : 'Add New Team Member'"></h3>
                    <button @click="openTeamModal = false" class="text-slate-400 hover:text-slate-700"><i class="bi bi-x-lg"></i></button>
                </div>

                <form :action="editingMemberId ? ('/admin/team/quick-update/' + editingMemberId) : '{{ route('admin.team.quick-store') }}'" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">First Name <span class="text-rose-500">*</span></label>
                            <input type="text" name="first_name" x-model="memberFirst" required placeholder="e.g. Wanjiku" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Last Name</label>
                            <input type="text" name="last_name" x-model="memberLast" placeholder="e.g. Mwangi" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Role / Title <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" x-model="memberRole" required placeholder="e.g. Managing Director &middot; Hydrogeologist" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Short Bio</label>
                        <textarea name="description" x-model="memberBio" rows="2" placeholder="Brief professional background" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Display Order</label>
                            <input type="number" name="order" x-model="memberOrder" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Status</label>
                            <select name="status" x-model="memberStatus" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-1.5 pt-2">
                        <label class="block text-xs font-bold text-slate-700">Profile Photo</label>
                        <input type="file" name="photo" accept="image/*" @change="onImagePick($event, 'memberPreviewUrl')" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                    </div>

                    @include('admin.partials.image-focus-picker', [
                        'focusX' => 'memberFocusX',
                        'focusY' => 'memberFocusY',
                        'previewUrl' => 'memberPreviewUrl',
                    ])

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                        <label class="flex items-center gap-2 text-xs font-semibold text-slate-700 cursor-pointer">
                            <input type="checkbox" name="founder" value="1" x-model="memberFounder" class="w-4 h-4 rounded text-brand-600">
                            <span>Show "FOUNDER" Badge</span>
                        </label>

                        <div class="flex items-center gap-3">
                            <button type="button" @click="openTeamModal = false" class="px-4 py-2 bg-slate-100 text-slate-700 text-xs font-bold rounded-xl">Cancel</button>
                            <button type="submit" class="px-5 py-2 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30">Save Member</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL 3: ADD / EDIT SERVICE -->
    <div x-show="openServiceModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="min-h-full px-4 py-8 flex items-center justify-center">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="openServiceModal = false"></div>

            <div class="relative bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-lg w-full p-6 lg:p-8 space-y-6 z-10">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <h3 class="text-base font-bold text-slate-900" x-text="editingServiceId !== null ? 'Edit Service' : 'Add Service'"></h3>
                    <button @click="openServiceModal = false" class="text-slate-400 hover:text-slate-700"><i class="bi bi-x-lg"></i></button>
                </div>

                <form :action="editingServiceId ? ('/admin/services/quick-update/' + editingServiceId) : '{{ route('admin.services.quick-store') }}'" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Title <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" x-model="serviceTitle" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Short summary</label>
                        <textarea name="short_description" x-model="serviceShortDesc" rows="2" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition"></textarea>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Highlight quote</label>
                        <input type="text" name="quote" x-model="serviceQuote" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Display order</label>
                            <input type="number" name="order" x-model="serviceOrder" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Status</label>
                            <select name="status" x-model="serviceStatus" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Cover photo</label>
                        <input type="file" name="image" accept="image/*" @change="onImagePick($event, 'servicePreviewUrl')" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                    </div>

                    @include('admin.partials.image-focus-picker', [
                        'focusX' => 'serviceFocusX',
                        'focusY' => 'serviceFocusY',
                        'previewUrl' => 'servicePreviewUrl',
                    ])

                    <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                        <button type="button" @click="openServiceModal = false" class="px-4 py-2 bg-slate-100 text-slate-700 text-xs font-bold rounded-xl">Cancel</button>
                        <button type="submit" class="px-5 py-2 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30">Save Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL 4: ADD / EDIT PROJECT -->
    <div x-show="openProjectModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="min-h-full px-4 py-8 flex items-center justify-center">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="openProjectModal = false"></div>
            <div class="relative bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-lg w-full p-6 lg:p-8 space-y-6 z-10">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <h3 class="text-base font-bold text-slate-900" x-text="editingProjectId ? 'Edit project' : 'Add project'"></h3>
                    <button @click="openProjectModal = false" class="text-slate-400 hover:text-slate-700"><i class="bi bi-x-lg"></i></button>
                </div>
                <form :action="editingProjectId ? ('/admin/portfolio/quick-update/' + editingProjectId) : '{{ route('admin.portfolio.quick-store') }}'" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Project name</label>
                        <input type="text" name="name" x-model="projectName" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Category tag</label>
                            <input type="text" name="category" x-model="projectCategory" placeholder="Irrigation" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Link</label>
                            <input type="text" name="link" x-model="projectLink" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                        </div>
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Summary</label>
                        <textarea name="description" x-model="projectDescription" rows="3" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Order</label>
                            <input type="number" name="order" x-model="projectOrder" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Status</label>
                            <select name="status" x-model="projectStatus" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Cover photo</label>
                        <input type="file" name="image" accept="image/*" @change="onImagePick($event, 'projectPreviewUrl')" class="w-full text-xs file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700">
                    </div>

                    @include('admin.partials.image-focus-picker', [
                        'focusX' => 'projectFocusX',
                        'focusY' => 'projectFocusY',
                        'previewUrl' => 'projectPreviewUrl',
                    ])

                    <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                        <button type="button" @click="openProjectModal = false" class="px-4 py-2 bg-slate-100 text-slate-700 text-xs font-bold rounded-xl">Cancel</button>
                        <button type="submit" class="px-5 py-2 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30">Save project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL 5: ADD / EDIT CLIENT / PARTNER -->
    <div x-show="openClientModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak>
        <div class="min-h-full px-4 py-8 flex items-center justify-center">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="openClientModal = false"></div>
            <div class="relative bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-lg w-full p-6 lg:p-8 space-y-6 z-10">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <h3 class="text-base font-bold text-slate-900" x-text="editingClientId ? 'Edit logo' : 'Add logo'"></h3>
                    <button @click="openClientModal = false" class="text-slate-400 hover:text-slate-700"><i class="bi bi-x-lg"></i></button>
                </div>
                <form :action="editingClientId ? ('/admin/clients/quick-update/' + editingClientId) : '{{ route('admin.clients.quick-store') }}'" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Organization name</label>
                        <input type="text" name="name" x-model="clientName" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Type</label>
                            <select name="type" x-model="clientType" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                                <option value="client">Client</option>
                                <option value="partner">Partner</option>
                            </select>
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Website link</label>
                            <input type="text" name="link" x-model="clientLink" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Order</label>
                            <input type="number" name="order" x-model="clientOrder" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-slate-700">Status</label>
                            <select name="status" x-model="clientStatus" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Logo image</label>
                        <input type="file" name="image" accept="image/*" @change="onImagePick($event, 'clientPreviewUrl')" class="w-full text-xs file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700">
                    </div>

                    @include('admin.partials.image-focus-picker', [
                        'focusX' => 'clientFocusX',
                        'focusY' => 'clientFocusY',
                        'previewUrl' => 'clientPreviewUrl',
                    ])

                    <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                        <button type="button" @click="openClientModal = false" class="px-4 py-2 bg-slate-100 text-slate-700 text-xs font-bold rounded-xl">Cancel</button>
                        <button type="submit" class="px-5 py-2 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@include('admin.home-sections._builder-alpine')
@include('admin.partials._preview-bridge')
@endsection
