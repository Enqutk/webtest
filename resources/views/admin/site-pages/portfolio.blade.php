@extends('admin.site-pages.layout')

@section('title', 'Portfolio page')
@section('page-title', 'Portfolio page')
@section('page-subtitle', $currentOrg->title)

@section('page-form')
    <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm mb-4">
        <p class="text-xs text-slate-500">Individual projects are managed under <a href="{{ route('admin.portfolio.index') }}" class="text-brand-700 font-bold hover:underline">Portfolio Projects</a> in the sidebar.</p>
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
@endsection
