@extends('admin.site-pages.layout')

@section('title', 'About page')
@section('page-title', 'About page')
@section('page-subtitle', $currentOrg->title)

@section('page-form')
@php
    $intro = $data['intro'] ?? [];
    $story = $data['story'] ?? [];
    $points = $intro['points'] ?? [];
    $panels = $story['panels'] ?? [];
    $introImage = \App\Models\Organization::themeFileUrl($intro['image'] ?? null);
@endphp

<div x-data="{
    points: @json($points),
    panels: @json($panels),
    addPoint() { this.points.push({ title: '', icon: 'bi bi-check-lg', description: '' }); },
    addPanel() { this.panels.push({ title: '', description: '', image: null }); },
    pushIntroField(field, value) {
        if (field === 'description') {
            value = (value || '').replace(/\n/g, '<br>');
        }
        window.AdminPreview?.pushField('about-page-intro', field, value);
    },
    pushPointField(index, field, value) {
        window.AdminPreview?.pushField('about-page-intro', 'point-' + index + '-' + field, value);
    },
    pushStoryField(field, value) {
        window.AdminPreview?.pushField('about-page-story', field, value);
    }
}">

    <form action="{{ route('admin.site-pages.update', 'about') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div id="page-header" class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-4">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Page header banner</h3>
                <p class="text-[11px] text-slate-500 mt-0.5">The title bar at the very top of the About page, above the main intro.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-slate-100 pt-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Eyebrow</label>
                    <input type="text" name="eyebrow" value="{{ $data['eyebrow'] ?? '' }}" data-preview-bind="page-hero:eyebrow" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Title</label>
                    <input type="text" name="title" value="{{ $data['title'] ?? '' }}" required data-preview-bind="page-hero:title" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                </div>
            </div>
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Short description</label>
                <textarea name="description" rows="2" data-preview-bind="page-hero:description" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">{{ $data['description'] ?? '' }}</textarea>
            </div>
        </div>

        <div id="about-page-intro" class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-4">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Main intro section</h3>
                <p class="text-[11px] text-slate-500 mt-0.5">The &ldquo;Who we are&rdquo; block with photo, heading, and feature cards shown in the preview below the banner.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-slate-100 pt-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Eyebrow</label>
                    <input type="text" name="intro_eyebrow" value="{{ $intro['eyebrow'] ?? '' }}" data-preview-bind="about-page-intro:eyebrow" @input="pushIntroField('eyebrow', $event.target.value)" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Heading</label>
                    <input type="text" name="intro_title" value="{{ $intro['title'] ?? '' }}" data-preview-bind="about-page-intro:title" @input="pushIntroField('title', $event.target.value)" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                </div>
            </div>
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Introduction</label>
                <textarea name="intro_description" rows="4" data-preview-bind="about-page-intro:description" @input="pushIntroField('description', $event.target.value)" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">{{ $intro['description'] ?? '' }}</textarea>
            </div>
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Intro photo</label>
                @if($introImage)
                    <img src="{{ $introImage }}" alt="" class="w-40 h-24 object-cover rounded-xl border border-slate-200 mb-2">
                @endif
                <input type="file" name="intro_image" accept="image/*" class="w-full text-xs file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700">
            </div>

            <div class="pt-2">
                <div class="flex items-center justify-between mb-3">
                    <label class="text-xs font-bold text-slate-700">Feature cards</label>
                    <button type="button" @click="addPoint()" class="text-xs font-bold text-brand-700 hover:text-brand-600">+ Add card</button>
                </div>
                <template x-for="(point, index) in points" :key="index">
                    <div :id="'about-point-' + index" class="grid grid-cols-1 md:grid-cols-3 gap-3 p-3 mb-3 rounded-xl bg-slate-50 border border-slate-100">
                        <input type="text" :name="'points['+index+'][title]'" x-model="point.title" @input="pushPointField(index, 'title', point.title)" placeholder="Title" class="px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs">
                        <input type="text" :name="'points['+index+'][icon]'" x-model="point.icon" placeholder="bi bi-check-lg" class="px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-mono">
                        <div class="flex gap-2">
                            <input type="text" :name="'points['+index+'][description]'" x-model="point.description" @input="pushPointField(index, 'description', point.description)" placeholder="Description" class="flex-1 px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs">
                            <button type="button" @click="points.splice(index, 1)" class="px-2 text-rose-500"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <div id="about-page-story" class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-4">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Story panels</h3>
                <p class="text-[11px] text-slate-500 mt-0.5">The &ldquo;Our story&rdquo; section with two side-by-side panels further down the page.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-slate-100 pt-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Eyebrow</label>
                    <input type="text" name="story_eyebrow" value="{{ $story['eyebrow'] ?? '' }}" data-preview-bind="about-page-story:eyebrow" @input="pushStoryField('eyebrow', $event.target.value)" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Heading</label>
                    <input type="text" name="story_title" value="{{ $story['title'] ?? '' }}" data-preview-bind="about-page-story:title" @input="pushStoryField('title', $event.target.value)" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                </div>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-700">Panels</span>
                <button type="button" @click="addPanel()" class="text-xs font-bold text-brand-700">+ Add panel</button>
            </div>
            <template x-for="(panel, index) in panels" :key="index">
                <div class="p-4 mb-3 rounded-xl border border-slate-200 space-y-3">
                    <div class="flex justify-between">
                        <input type="text" :name="'panels['+index+'][title]'" x-model="panel.title" placeholder="Panel title" class="flex-1 px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-bold">
                        <button type="button" @click="panels.splice(index, 1)" class="ml-2 text-rose-500"><i class="bi bi-trash"></i></button>
                    </div>
                    <textarea :name="'panels['+index+'][description]'" x-model="panel.description" rows="3" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs"></textarea>
                    <input type="hidden" :name="'panels['+index+'][image]'" :value="panel.image || ''">
                    <input type="file" :name="'panel_images['+index+']'" accept="image/*" class="w-full text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700">
                </div>
            </template>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-3">
            <h3 class="text-sm font-bold text-slate-900">Shared blocks on this page</h3>
            <p class="text-xs text-slate-500">Turn these on or off here. The lists themselves stay under Team, Portfolio, and Home.</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <label class="flex items-center gap-2 text-xs font-semibold"><input type="checkbox" name="show_stats" value="1" {{ !empty($data['show_stats']) ? 'checked' : '' }} class="rounded text-brand-600"> Stats</label>
                <label class="flex items-center gap-2 text-xs font-semibold"><input type="checkbox" name="show_team" value="1" {{ !empty($data['show_team']) ? 'checked' : '' }} class="rounded text-brand-600"> Team</label>
                <label class="flex items-center gap-2 text-xs font-semibold"><input type="checkbox" name="show_clients" value="1" {{ !empty($data['show_clients']) ? 'checked' : '' }} class="rounded text-brand-600"> Clients</label>
                <label class="flex items-center gap-2 text-xs font-semibold"><input type="checkbox" name="show_cta" value="1" {{ !empty($data['show_cta']) ? 'checked' : '' }} class="rounded text-brand-600"> Contact banner</label>
            </div>
        </div>

        <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-brand-600 hover:bg-brand-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-brand-600/30">Save About page</button>
    </form>
</div>
@endsection
