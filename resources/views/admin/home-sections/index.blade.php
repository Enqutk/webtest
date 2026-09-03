@extends('admin.layouts.app')

@section('title', 'Home Page Sections')
@section('page-title', 'Home Page Visual Builder')
@section('page-subtitle', $currentOrg->title)

@section('content')
@php
    $liveHomeUrl = route('card.home', ['slug' => $currentOrg->slug]);
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

    $heroSlides = $hero['slides'] ?? \App\Models\Organization::defaultHeroSlides();
@endphp

<div class="space-y-6" x-data="{
    activeSection: 'hero',
    openSlideModal: false,
    editingSlideIndex: null,
    slideTitle: '',
    slideSubtitle: '',
    slideDesc: '',
    slideBtnText: 'Explore services',
    slideBtnLink: '/our-services',
    slideShape: 'inherit',
    slideVisible: true,

    // Team Modal
    openTeamModal: false,
    editingMemberId: null,
    memberFirst: '',
    memberLast: '',
    memberRole: '',
    memberBio: '',
    memberOrder: 1,
    memberStatus: 'active',
    memberFounder: false,

    editSlide(index, slide) {
        this.editingSlideIndex = index;
        this.slideTitle = slide.title || '';
        this.slideSubtitle = slide.subtitle || '';
        this.slideDesc = slide.description || '';
        this.slideBtnText = slide.text_link || 'Explore services';
        this.slideBtnLink = slide.button_link || '/our-services';
        this.slideShape = slide.image_shape || 'inherit';
        this.slideVisible = (slide.is_visible !== false);
        this.openSlideModal = true;
    },

    newSlide() {
        this.editingSlideIndex = null;
        this.slideTitle = '';
        this.slideSubtitle = '';
        this.slideDesc = '';
        this.slideBtnText = 'Explore services';
        this.slideBtnLink = '/our-services';
        this.slideShape = 'inherit';
        this.slideVisible = true;
        this.openSlideModal = true;
    },

    editMember(m) {
        this.editingMemberId = m.id;
        this.memberFirst = m.first_name || '';
        this.memberLast = m.last_name || '';
        this.memberRole = m.title || '';
        this.memberBio = m.description || '';
        this.memberOrder = m.order || 1;
        this.memberStatus = m.status?.value || m.status || 'active';
        this.memberFounder = !!m.founder;
        this.openTeamModal = true;
    },

    newMember() {
        this.editingMemberId = null;
        this.memberFirst = '';
        this.memberLast = '';
        this.memberRole = '';
        this.memberBio = '';
        this.memberOrder = {{ ($teamMembers->max('order') ?? 0) + 1 }};
        this.memberStatus = 'active';
        this.memberFounder = false;
        this.openTeamModal = true;
    }
}">

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
        <button type="button" @click="activeSection = 'hero'" :class="activeSection === 'hero' ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2">
            <span>🌟</span>
            <span>Hero Banner ({{ count($heroSlides) }})</span>
        </button>
        <button type="button" @click="activeSection = 'about'" :class="activeSection === 'about' ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2">
            <span>🏛️</span>
            <span>About & Mission</span>
        </button>
        <button type="button" @click="activeSection = 'services'" :class="activeSection === 'services' ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2">
            <span>🔧</span>
            <span>Services Section</span>
        </button>
        <button type="button" @click="activeSection = 'stats'" :class="activeSection === 'stats' ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2">
            <span>📈</span>
            <span>Impact & Stats</span>
        </button>
        <button type="button" @click="activeSection = 'portfolio'" :class="activeSection === 'portfolio' ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2">
            <span>💼</span>
            <span>Portfolio Section</span>
        </button>
        <button type="button" @click="activeSection = 'team'" :class="activeSection === 'team' ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2">
            <span>👥</span>
            <span>Leadership Team ({{ $teamMembers->count() }})</span>
        </button>
        <button type="button" @click="activeSection = 'clients'" :class="activeSection === 'clients' ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2">
            <span>🤝</span>
            <span>Clients & Partners</span>
        </button>
        <button type="button" @click="activeSection = 'cta'" :class="activeSection === 'cta' ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-slate-600 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2">
            <span>📣</span>
            <span>CTA Banner</span>
        </button>
    </div>

    <!-- Live Homepage Preview (collapsible) -->
    <div x-data="{ previewOpen: true }" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <button type="button" @click="previewOpen = !previewOpen" class="w-full flex items-center justify-between p-4 hover:bg-slate-50 transition">
            <div class="flex items-center gap-2">
                <i class="bi bi-eye text-brand-600"></i>
                <span class="text-sm font-bold text-slate-900">Live Homepage Preview</span>
                <span class="text-xs text-slate-400">(saved version)</span>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ $liveHomeUrl }}" target="_blank" rel="noopener" @click.stop
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg transition">
                    <i class="bi bi-box-arrow-up-right"></i> Open live
                </a>
                <i class="bi text-slate-400 transition-transform" :class="previewOpen ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
            </div>
        </button>
        <div x-show="previewOpen" x-collapse>
            <iframe
                src="{{ $liveHomeUrl }}"
                class="w-full border-t border-slate-100"
                style="height: 480px; border: 0; background: white;"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
        </div>
    </div>

    <!-- 🌟 SECTION 1: HERO BANNER & SLIDES -->
    <div x-show="activeSection === 'hero'" class="space-y-6">
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
                    <input type="text" name="badge" value="{{ $hero['badge'] ?? 'Infrastructure · Engineering · Impact' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Category / Subtitle</label>
                    <input type="text" name="subtitle" value="{{ $hero['subtitle'] ?? 'Engineering Excellence' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
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
                <input type="text" name="title" value="{{ $hero['title'] ?? 'Building resilient infrastructure for lasting communities' }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:bg-white transition">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Supporting Description</label>
                <textarea name="description" rows="2" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">{{ $hero['description'] ?? '' }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-100">
                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Primary Button Text</label>
                        <input type="text" name="cta_text" value="{{ $hero['cta_text'] ?? 'Explore Our Work' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Primary Link</label>
                        <input type="text" name="cta_url" value="{{ $hero['cta_url'] ?? '/portfolio' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-700">Secondary Button Text</label>
                        <input type="text" name="secondary_cta_text" value="{{ $hero['secondary_cta_text'] ?? 'Our Services' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
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
                                    <img src="{{ $fullImgUrl }}" alt="slide" class="w-full h-full object-cover">
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
    <div x-show="activeSection === 'team'" class="space-y-6" x-cloak>
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
                    <input type="text" name="eyebrow" value="{{ $teamSec['eyebrow'] ?? 'Leadership & Team' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Section Heading</label>
                    <input type="text" name="title" value="{{ $teamSec['title'] ?? 'Experienced engineers & hydrologists' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
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
                <textarea name="description" rows="2" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">{{ $teamSec['description'] ?? '' }}</textarea>
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
                            <button type="button" @click="editMember({{ json_encode($m) }})" class="px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-100 text-xs font-bold rounded-lg transition">
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
    <div x-show="activeSection === 'about'" class="space-y-6" x-cloak>
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
                    <input type="text" name="eyebrow" value="{{ $about['eyebrow'] ?? 'About our firm' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Headline</label>
                    <input type="text" name="title" value="{{ $about['title'] ?? 'Rooted in East Africa, built for scale' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
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
                <textarea name="paragraph_1" rows="2" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">{{ $about['paragraph_1'] ?? '' }}</textarea>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Paragraph 2</label>
                <textarea name="paragraph_2" rows="2" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">{{ $about['paragraph_2'] ?? '' }}</textarea>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30 transition">
                    Save About Settings
                </button>
            </div>
        </form>
    </div>

    <!-- 🔧 SECTION 3: SERVICES SECTION -->
    <div x-show="activeSection === 'services'" class="space-y-6" x-cloak>
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
                    <input type="text" name="eyebrow" value="{{ $servicesSec['eyebrow'] ?? 'Core Capabilities' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Heading</label>
                    <input type="text" name="title" value="{{ $servicesSec['title'] ?? 'Integrated solutions for complex infrastructure' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Description</label>
                <textarea name="description" rows="2" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">{{ $servicesSec['description'] ?? '' }}</textarea>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30 transition">
                    Save Services Settings
                </button>
            </div>
        </form>
    </div>

    <!-- 📈 SECTION 4: STATS SECTION -->
    <div x-show="activeSection === 'stats'" class="space-y-6" x-cloak>
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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Stat 1 (Value & Label)</label>
                    <input type="text" name="stat_1_value" value="{{ $statsSec['stat_1_value'] ?? '120+' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:bg-white transition mb-1.5">
                    <input type="text" name="stat_1_label" value="{{ $statsSec['stat_1_label'] ?? 'Projects completed' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Stat 2 (Value & Label)</label>
                    <input type="text" name="stat_2_value" value="{{ $statsSec['stat_2_value'] ?? '2.4M' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:bg-white transition mb-1.5">
                    <input type="text" name="stat_2_label" value="{{ $statsSec['stat_2_label'] ?? 'People served' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Stat 3 (Value & Label)</label>
                    <input type="text" name="stat_3_value" value="{{ $statsSec['stat_3_value'] ?? '99.2%' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-900 focus:bg-white transition mb-1.5">
                    <input type="text" name="stat_3_label" value="{{ $statsSec['stat_3_label'] ?? 'Scheme uptime' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
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
    <div x-show="activeSection === 'portfolio'" class="space-y-6" x-cloak>
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
                    <input type="text" name="eyebrow" value="{{ $portfolioSec['eyebrow'] ?? 'Featured Projects' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Heading</label>
                    <input type="text" name="title" value="{{ $portfolioSec['title'] ?? 'Delivering resilient infrastructure across East Africa' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
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
    </div>

    <!-- 📣 SECTION 7: CTA BANNER -->
    <div x-show="activeSection === 'cta'" class="space-y-6" x-cloak>
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
                    <input type="text" name="title" value="{{ $ctaSec['title'] ?? 'Ready to build water infrastructure that lasts?' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Button Text & Link</label>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="text" name="button_text" value="{{ $ctaSec['button_text'] ?? 'Talk to an engineer' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
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
                        <input type="file" name="slide_image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                    </div>

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
                        <input type="file" name="photo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                    </div>

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

</div>
@endsection
