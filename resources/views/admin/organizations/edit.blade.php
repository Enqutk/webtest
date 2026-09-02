@extends('admin.layouts.app')

@section('title', 'Organization Settings')
@section('page-title', 'Organization & Brand Customizer')
@section('page-subtitle', $organization->title)

@section('content')
@php
    $theme = is_array($organization->theme) ? $organization->theme : \App\Models\Organization::defaultTheme();
    $logoUrl = $organization->getFirstMediaUrl('logo');
    $faviconUrl = $organization->getFirstMediaUrl('favicon');
@endphp

<div class="space-y-6" x-data="{
    activeTab: 'brand',
    title: '{{ addslashes($organization->title) }}',
    tagline: '{{ addslashes($organization->tagline ?? '') }}',
    accentColor: '{{ $theme['accent'] ?? '#ea580c' }}',
    displayFont: '{{ $theme['font_display'] ?? 'Fraunces' }}',
    bodyFont: '{{ $theme['font_body'] ?? 'Outfit' }}',
    imageShape: '{{ $theme['image_shape'] ?? 'rounded-xl' }}',
    showBrandText: {{ !empty($theme['show_brand_text']) ? 'true' : 'false' }},
    showTagline: {{ !empty($theme['show_tagline']) ? 'true' : 'false' }}
}">

    <!-- Top Live Visual Preview Sticky Card -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-md p-4 lg:p-6 sticky top-2 z-30 backdrop-blur-md bg-white/95 transition-all">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                <span class="text-xs font-bold text-slate-800 uppercase tracking-wider">Live Real-time Brand & Navbar Preview</span>
            </div>
            <div class="flex items-center gap-3 text-xs text-slate-500">
                <span class="font-mono text-[11px]" x-text="'Accent: ' + accentColor"></span>
                <span>&bull;</span>
                <span class="font-mono text-[11px]" x-text="'Font: ' + displayFont"></span>
                <span>&bull;</span>
                <span class="font-mono text-[11px]" x-text="'Shape: ' + imageShape"></span>
            </div>
        </div>

        <!-- Live Header Bar Preview Container -->
        <div class="rounded-xl border border-slate-200 p-4 transition-all" style="background: #fdfbf7;">
            <div class="flex items-center justify-between">
                <!-- Brand Title / Logo Preview -->
                <div class="flex items-center gap-3">
                    @if($logoUrl)
                        <img src="{{ $logoUrl }}" alt="Logo" class="h-8 w-auto object-contain">
                    @else
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white font-bold text-sm" :style="'background: ' + accentColor">
                            <span x-text="title.substring(0, 1) || 'O'"></span>
                        </div>
                    @endif
                    <div x-show="showBrandText">
                        <span class="text-lg font-bold tracking-tight block leading-tight" :style="'font-family: ' + displayFont + ', serif; color: ' + accentColor" x-text="title || 'Your Brand'"></span>
                        <span x-show="showTagline && tagline" class="text-[10px] text-slate-500 block" x-text="tagline"></span>
                    </div>
                </div>

                <!-- Nav Mock -->
                <div class="hidden md:flex items-center gap-6 text-xs font-medium text-slate-700" :style="'font-family: ' + bodyFont + ', sans-serif;'">
                    <span class="font-bold border-b-2 pb-0.5" :style="'color: ' + accentColor + '; border-color: ' + accentColor">Home</span>
                    <span>About</span>
                    <span>Services</span>
                    <span>Portfolio</span>
                    <span>Contact</span>
                </div>

                <!-- CTA Mock -->
                <div>
                    <span class="px-3.5 py-1.5 rounded-lg text-white font-bold text-xs shadow-sm" :style="'background: ' + accentColor" :style="'font-family: ' + bodyFont">
                        {{ $theme['header_cta_text'] ?? 'Get in touch' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Settings Form with Tabs -->
    <form action="{{ route('admin.organizations.update', $organization) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Tabs Navigation -->
        <div class="bg-white rounded-2xl border border-slate-200/80 p-2 shadow-sm flex flex-wrap gap-1.5">
            <button type="button" @click="activeTab = 'brand'" :class="activeTab === 'brand' ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-slate-600 hover:bg-slate-100'" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2">
                <i class="bi bi-building"></i>
                <span>Brand & Identity</span>
            </button>
            <button type="button" @click="activeTab = 'styling'" :class="activeTab === 'styling' ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-slate-600 hover:bg-slate-100'" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2">
                <i class="bi bi-palette"></i>
                <span>Colors, Fonts & Shapes</span>
            </button>
            <button type="button" @click="activeTab = 'media'" :class="activeTab === 'media' ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-slate-600 hover:bg-slate-100'" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2">
                <i class="bi bi-image"></i>
                <span>Logo & Favicon</span>
            </button>
            <button type="button" @click="activeTab = 'contact'" :class="activeTab === 'contact' ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-slate-600 hover:bg-slate-100'" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2">
                <i class="bi bi-geo-alt"></i>
                <span>Contact & Location</span>
            </button>
            <button type="button" @click="activeTab = 'members'" :class="activeTab === 'members' ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20' : 'text-slate-600 hover:bg-slate-100'" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2">
                <i class="bi bi-people"></i>
                <span>Staff & Access ({{ $members->count() }})</span>
            </button>
        </div>

        <!-- Tab 1: Brand & Identity -->
        <div x-show="activeTab === 'brand'" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 lg:p-8 space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <h3 class="text-sm font-bold text-slate-900">Brand Identity & Tenant Domain</h3>
                <p class="text-xs text-slate-500">Configure company name, URL slug identifier, and custom domain routing.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Company Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" x-model="title" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:border-brand-500 transition">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Tenant URL Slug <span class="text-rose-500">*</span></label>
                    <input type="text" name="slug" value="{{ $organization->slug }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 font-mono focus:bg-white focus:outline-none focus:border-brand-500 transition">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Custom Domain (Optional)</label>
                    <input type="text" name="domain" value="{{ $organization->domain }}" placeholder="e.g. majiworks.org" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 font-mono focus:bg-white focus:outline-none focus:border-brand-500 transition">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Status</label>
                    <select name="status" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:border-brand-500 transition">
                        <option value="active" {{ $organization->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $organization->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Tagline</label>
                <input type="text" name="tagline" x-model="tagline" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:border-brand-500 transition">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">SEO Meta Description</label>
                <textarea name="meta_description" rows="2" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:border-brand-500 transition">{{ $organization->meta_description }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-slate-100">
                <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 bg-slate-50 cursor-pointer">
                    <input type="checkbox" name="theme[show_brand_text]" value="1" x-model="showBrandText" class="w-4 h-4 rounded text-brand-600">
                    <span class="text-xs font-semibold text-slate-700">Show Brand Name Text in Header</span>
                </label>
                <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 bg-slate-50 cursor-pointer">
                    <input type="checkbox" name="theme[show_tagline]" value="1" x-model="showTagline" class="w-4 h-4 rounded text-brand-600">
                    <span class="text-xs font-semibold text-slate-700">Show Tagline in Header</span>
                </label>
            </div>
        </div>

        <!-- Tab 2: Colors, Fonts & Shapes -->
        <div x-show="activeTab === 'styling'" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 lg:p-8 space-y-6" x-cloak>
            <div class="border-b border-slate-100 pb-4">
                <h3 class="text-sm font-bold text-slate-900">Colors, Typography & Picture Shapes</h3>
                <p class="text-xs text-slate-500">Pick tailored brand palette colors, curated Google Fonts, and site-wide geometric picture shape presets.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Accent Color -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Primary Brand Accent Color</label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="theme[accent]" x-model="accentColor" class="w-12 h-10 p-0.5 rounded-xl border border-slate-200 cursor-pointer bg-white">
                        <input type="text" x-model="accentColor" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono text-slate-900">
                    </div>
                </div>

                <!-- Secondary Accent -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Secondary Accent Color</label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="theme[accent_secondary]" value="{{ $theme['accent_secondary'] ?? '#0f766e' }}" class="w-12 h-10 p-0.5 rounded-xl border border-slate-200 cursor-pointer bg-white">
                        <input type="text" name="theme[accent_secondary]" value="{{ $theme['accent_secondary'] ?? '#0f766e' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono text-slate-900">
                    </div>
                </div>

                <!-- Display Font -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Display / Headline Font</label>
                    <select name="theme[font_display]" x-model="displayFont" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                        @foreach($fontOptions as $font => $label)
                            <option value="{{ $font }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Body Font -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Body & Navigation Font</label>
                    <select name="theme[font_body]" x-model="bodyFont" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                        @foreach($fontOptions as $font => $label)
                            <option value="{{ $font }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Global Picture Shape Presets -->
            <div class="space-y-2 pt-4 border-t border-slate-100">
                <label class="block text-xs font-bold text-slate-700">Global Picture & Photo Shape Preset</label>
                <p class="text-[11px] text-slate-500 mb-3">Controls the geometric shape and corner curvature for all pictures across the entire homepage (Hero, About, Portfolio, Team).</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($shapeOptions as $key => $name)
                        <label class="flex items-center gap-2.5 p-3 rounded-xl border text-xs font-medium cursor-pointer transition"
                               :class="imageShape === '{{ $key }}' ? 'border-brand-500 bg-brand-50/50 text-brand-900 font-bold' : 'border-slate-200 bg-slate-50 text-slate-700 hover:bg-slate-100'">
                            <input type="radio" name="theme[image_shape]" value="{{ $key }}" x-model="imageShape" class="text-brand-600 focus:ring-brand-500">
                            <span>{{ $name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Tab 3: Logo & Favicon -->
        <div x-show="activeTab === 'media'" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 lg:p-8 space-y-6" x-cloak>
            <div class="border-b border-slate-100 pb-4">
                <h3 class="text-sm font-bold text-slate-900">Brand Logo & Favicon</h3>
                <p class="text-xs text-slate-500">Upload header brand assets for this organization.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Logo -->
                <div class="space-y-3">
                    <label class="block text-xs font-bold text-slate-700">Brand Logo</label>
                    @if($logoUrl)
                        <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 flex items-center justify-center">
                            <img src="{{ $logoUrl }}" alt="Logo" class="max-h-16 w-auto object-contain">
                        </div>
                    @endif
                    <input type="file" name="logo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                </div>

                <!-- Favicon -->
                <div class="space-y-3">
                    <label class="block text-xs font-bold text-slate-700">Site Favicon</label>
                    @if($faviconUrl)
                        <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 flex items-center justify-center">
                            <img src="{{ $faviconUrl }}" alt="Favicon" class="w-10 h-10 object-contain">
                        </div>
                    @endif
                    <input type="file" name="favicon" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                </div>
            </div>
        </div>

        <!-- Tab 4: Contact & Location -->
        <div x-show="activeTab === 'contact'" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 lg:p-8 space-y-6" x-cloak>
            <div class="border-b border-slate-100 pb-4">
                <h3 class="text-sm font-bold text-slate-900">Address & Contact Details</h3>
                <p class="text-xs text-slate-500">Contact information displayed in the site footer and contact page.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">P.O. Box</label>
                    <input type="text" name="po_box" value="{{ $organization->po_box }}" placeholder="P.O. Box 12345, Nairobi" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Opening Hours</label>
                    @php
                        $formattedOpeningHours = '';
                        if (is_array($organization->opening_hours)) {
                            $formattedOpeningHours = collect($organization->opening_hours)->map(function ($h) {
                                if (is_string($h)) return $h;
                                if (is_array($h)) {
                                    $days = isset($h['days']) ? (is_array($h['days']) ? implode('-', array_map('ucfirst', $h['days'])) : $h['days']) : '';
                                    $from = $h['from'] ?? '';
                                    $to = $h['to'] ?? '';
                                    return trim("{$days}: {$from} - {$to}", ': -');
                                }
                                return '';
                            })->filter()->implode(', ');
                        } else {
                            $formattedOpeningHours = (string) ($organization->opening_hours ?? '');
                        }
                    @endphp
                    <input type="text" name="opening_hours" value="{{ $formattedOpeningHours }}" placeholder="Mon - Fri: 8:00 AM - 5:00 PM" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Physical Address</label>
                <textarea name="address" rows="2" placeholder="Office Location, Floor, Street" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">{{ $organization->address }}</textarea>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Google Map Embed Link</label>
                <input type="text" name="map_url" value="{{ $organization->map_url }}" placeholder="https://maps.google.com/..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white transition">
            </div>
        </div>

        <!-- Tab 5: Staff & Access -->
        <div x-show="activeTab === 'members'" class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 lg:p-8 space-y-6" x-cloak>
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Organization Staff & Access</h3>
                    <p class="text-xs text-slate-500">Users authorized to manage this organization's content and settings.</p>
                </div>
            </div>

            <!-- Members List -->
            <div class="space-y-3">
                @foreach($members as $m)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200/80">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold text-xs">
                                {{ mb_substr($m->name, 0, 1) }}
                            </div>
                            <div>
                                <span class="text-xs font-bold text-slate-900 block">{{ $m->name }}</span>
                                <span class="text-[11px] text-slate-500">{{ $m->email }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-brand-50 text-brand-700 uppercase tracking-wider">
                                {{ $m->pivot->role ?? 'member' }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Submit Save Bar -->
        <div class="sticky bottom-4 z-20 bg-white/95 backdrop-blur-md p-4 rounded-2xl border border-slate-200 shadow-xl flex items-center justify-between gap-4">
            <span class="text-xs text-slate-500">Make sure to save your changes to apply updates to your live website.</span>
            <button type="submit" class="px-6 py-2.5 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30 transition flex items-center gap-2 shrink-0">
                <i class="bi bi-check2-circle text-base"></i>
                <span>Save Organization Settings</span>
            </button>
        </div>
    </form>

</div>
@endsection
