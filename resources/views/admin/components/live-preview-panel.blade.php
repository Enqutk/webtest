@props([
    'previewUrl',
    'liveUrl',
    'label' => 'Page',
    'hint' => 'Click any highlighted area in the preview to jump to that setting.',
    'badge' => null,
])

<aside class="home-builder-preview">
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden h-full">
        <div class="flex items-center justify-between gap-3 p-3 sm:p-4 border-b border-slate-100 bg-slate-50/80">
            <div class="min-w-0">
                <div class="flex items-center gap-2 flex-wrap">
                    <i class="bi bi-eye text-brand-600"></i>
                    <span class="text-sm font-bold text-slate-900">Live Preview</span>
                    @if($badge)
                        <span class="px-2 py-0.5 rounded-md bg-brand-50 text-brand-700 text-[11px] font-bold">{{ $badge }}</span>
                    @else
                        <span class="px-2 py-0.5 rounded-md bg-brand-50 text-brand-700 text-[11px] font-bold">{{ $label }}</span>
                    @endif
                </div>
                <p class="text-[11px] text-slate-500 mt-0.5">{{ $hint }}</p>
            </div>
            <a href="{{ $liveUrl }}" target="_blank" rel="noopener"
               class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-lg transition">
                <i class="bi bi-box-arrow-up-right"></i> Open
            </a>
        </div>
        <iframe
            x-ref="previewFrame"
            src="{{ $previewUrl }}"
            class="w-full bg-white block"
            style="height: min(75vh, 780px); border: 0;"
            loading="eager"
            referrerpolicy="no-referrer-when-downgrade"
            @load="onPreviewLoad()"
        ></iframe>
    </div>
</aside>
