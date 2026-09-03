@extends('admin.layouts.app')

@section('title', 'About page')
@section('page-title', 'About page')
@section('page-subtitle', $currentOrg->title)

@section('content')
@php
    $intro = $data['intro'] ?? [];
    $story = $data['story'] ?? [];
    $points = $intro['points'] ?? [];
    $panels = $story['panels'] ?? [];
    $introImage = \App\Models\Organization::themeFileUrl($intro['image'] ?? null);
@endphp

<div class="space-y-6" x-data="{
    points: @json($points),
    panels: @json($panels),
    addPoint() { this.points.push({ title: '', icon: 'bi bi-check-lg', description: '' }); },
    addPanel() { this.panels.push({ title: '', description: '', image: null }); }
}">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h2 class="text-base font-bold text-slate-900">About page content</h2>
            <p class="text-xs text-slate-500 mt-0.5">Everything on this screen is for the About page only. Team, clients, and the contact banner stay in their own menus.</p>
        </div>
        <a href="{{ $liveUrl }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl">
            <i class="bi bi-box-arrow-up-right"></i> View live About
        </a>
    </div>

    <form action="{{ route('admin.site-pages.update', 'about') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-4">
            <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3">Page header</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Eyebrow</label>
                    <input type="text" name="eyebrow" value="{{ $data['eyebrow'] ?? '' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Title</label>
                    <input type="text" name="title" value="{{ $data['title'] ?? '' }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                </div>
            </div>
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Short description</label>
                <textarea name="description" rows="2" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">{{ $data['description'] ?? '' }}</textarea>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-4">
            <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3">Intro</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Eyebrow</label>
                    <input type="text" name="intro_eyebrow" value="{{ $intro['eyebrow'] ?? '' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Heading</label>
                    <input type="text" name="intro_title" value="{{ $intro['title'] ?? '' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                </div>
            </div>
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-700">Introduction</label>
                <textarea name="intro_description" rows="4" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">{{ $intro['description'] ?? '' }}</textarea>
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
                    <label class="text-xs font-bold text-slate-700">Highlight points</label>
                    <button type="button" @click="addPoint()" class="text-xs font-bold text-brand-700 hover:text-brand-600">+ Add point</button>
                </div>
                <template x-for="(point, index) in points" :key="index">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 p-3 mb-3 rounded-xl bg-slate-50 border border-slate-100">
                        <input type="text" :name="'points['+index+'][title]'" x-model="point.title" placeholder="Title" class="px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs">
                        <input type="text" :name="'points['+index+'][icon]'" x-model="point.icon" placeholder="bi bi-check-lg" class="px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-mono">
                        <div class="flex gap-2">
                            <input type="text" :name="'points['+index+'][description]'" x-model="point.description" placeholder="Description" class="flex-1 px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs">
                            <button type="button" @click="points.splice(index, 1)" class="px-2 text-rose-500"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-4">
            <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3">Story panels</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Eyebrow</label>
                    <input type="text" name="story_eyebrow" value="{{ $story['eyebrow'] ?? '' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-700">Heading</label>
                    <input type="text" name="story_title" value="{{ $story['title'] ?? '' }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">
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

        <div class="sticky bottom-4">
            <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-brand-600 hover:bg-brand-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-brand-600/30">Save About page</button>
        </div>
    </form>
</div>
@endsection
