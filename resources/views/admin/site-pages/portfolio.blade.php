@extends('admin.layouts.app')

@section('title', 'Portfolio page')
@section('page-title', 'Portfolio page')
@section('page-subtitle', $currentOrg->title)

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h2 class="text-base font-bold text-slate-900">Portfolio listing header</h2>
            <p class="text-xs text-slate-500 mt-0.5">This page only. Projects and client logos stay under Website → Portfolio Projects.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.portfolio.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 text-xs font-bold rounded-xl">Edit projects</a>
            <a href="{{ $liveUrl }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl">
                <i class="bi bi-box-arrow-up-right"></i> View live
            </a>
        </div>
    </div>

    <form action="{{ route('admin.site-pages.update', 'portfolio') }}" method="POST" class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-4">
        @csrf
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
            <label class="block text-xs font-bold text-slate-700">Description</label>
            <textarea name="description" rows="3" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs">{{ $data['description'] ?? '' }}</textarea>
        </div>
        <button type="submit" class="px-6 py-3 bg-brand-600 hover:bg-brand-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-brand-600/30">Save Portfolio page</button>
    </form>
</div>
@endsection
