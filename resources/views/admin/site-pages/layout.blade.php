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
<div class="home-builder-shell" x-data="adminPreviewPanel()" x-init="init()">
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

    @include('admin.components.live-preview-panel', [
        'previewUrl' => $previewUrl,
        'liveUrl' => $liveUrl,
        'label' => $meta['label'] ?? 'Page',
        'hint' => 'Click any highlighted area to jump to that setting. Edits update live when supported.',
    ])
</div>
@endsection

@push('scripts')
@include('admin.partials._preview-bridge')
@endpush
