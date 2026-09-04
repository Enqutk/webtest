@extends('admin.layouts.app')

@push('styles')
<style>
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
        .home-builder-editor { flex-basis: 34%; width: 34%; max-width: 34%; }
        .home-builder-preview { flex-basis: 66%; width: 66%; }
    }
</style>
@endpush

@section('content')
<div class="home-builder-shell">
    <div class="home-builder-editor space-y-6">
        @if(!request()->routeIs('admin.site-settings.*'))
        <a href="{{ route('admin.site-settings.index') }}" class="flex items-center justify-between gap-3 p-4 rounded-2xl border border-slate-200/80 bg-white shadow-sm hover:border-brand-200 hover:bg-brand-50/30 transition group">
            <div class="min-w-0">
                <div class="text-xs font-bold text-slate-900 group-hover:text-brand-800">Header, footer & navigation</div>
                <p class="text-[11px] text-slate-500 mt-0.5">Edit shared site chrome used on every page.</p>
            </div>
            <i class="bi bi-gear-fill text-brand-600 shrink-0"></i>
        </a>
        @endif

        @yield('page-form')
    </div>

    <aside class="home-builder-preview">
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between gap-3 p-3 sm:p-4 border-b border-slate-100 bg-slate-50/80">
                <div class="min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <i class="bi bi-eye text-brand-600"></i>
                        <span class="text-sm font-bold text-slate-900">Live Preview</span>
                        <span class="px-2 py-0.5 rounded-md bg-brand-50 text-brand-700 text-[11px] font-bold">{{ $meta['label'] ?? 'Page' }}</span>
                    </div>
                    <p class="text-[11px] text-slate-500 mt-0.5">Click header, footer, or page areas in the preview to jump to the editor.</p>
                </div>
                <a href="{{ $liveUrl }}" target="_blank" rel="noopener"
                   class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-lg transition">
                    <i class="bi bi-box-arrow-up-right"></i> Open
                </a>
            </div>
            <iframe
                src="{{ $previewUrl }}"
                class="w-full bg-white block"
                style="height: min(75vh, 780px); border: 0;"
                loading="eager"
                referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
        </div>
    </aside>
</div>
@endsection

@push('scripts')
@include('admin.partials.preview-navigate')
@endpush
