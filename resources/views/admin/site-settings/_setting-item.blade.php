@props(['id' => null, 'title', 'hint' => null, 'icon' => null])

<section
    @if($id) id="{{ $id }}" @endif
    class="site-setting-item scroll-mt-4 py-4 border-b border-slate-200/70 last:border-b-0 transition-colors duration-300"
>
    <div class="flex items-start gap-2.5 mb-3">
        @if($icon)
            <span class="w-7 h-7 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center shrink-0">
                <i class="bi {{ $icon }} text-sm"></i>
            </span>
        @endif
        <div class="min-w-0">
            <h4 class="text-xs font-bold text-slate-900">{{ $title }}</h4>
            @if($hint)
                <p class="text-[11px] text-slate-500 mt-0.5 leading-relaxed">{{ $hint }}</p>
            @endif
        </div>
    </div>
    <div>{{ $slot ?? '' }}</div>
</section>
