{{-- Compact collapsible explainer — white theme --}}
@php
    $exampleUrl = url('/card/yeabsira-endale');
@endphp

<section class="rounded-2xl border border-slate-200 bg-white overflow-hidden shadow-sm">
    <button type="button"
            @click="explainerOpen = !explainerOpen"
            class="w-full flex items-center justify-between gap-3 px-4 py-3.5 text-left hover:bg-slate-50 transition min-h-[52px]">
        <div class="flex items-center gap-2.5 min-w-0">
            <div class="w-9 h-9 rounded-xl bg-amber-50 border border-amber-200 flex items-center justify-center shrink-0">
                <i class="bi bi-info-circle text-gold-600"></i>
            </div>
            <div class="min-w-0">
                <div class="text-xs font-bold text-slate-900">What is Kimem Cards?</div>
                <div class="text-[10px] text-slate-500 truncate">Tap NFC card → live profile → share contacts</div>
            </div>
        </div>
        <i class="bi text-slate-400 shrink-0" :class="explainerOpen ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
    </button>

    <div x-show="explainerOpen" x-transition class="px-4 pb-4 space-y-4 border-t border-slate-100">
        <div class="grid grid-cols-3 gap-2 pt-3">
            <div class="text-center p-2 rounded-xl bg-slate-50 border border-slate-200">
                <i class="bi bi-nfc text-gold-600 text-lg block mb-1"></i>
                <span class="text-[9px] font-bold text-slate-600">Tap</span>
            </div>
            <div class="text-center p-2 rounded-xl bg-slate-50 border border-slate-200">
                <i class="bi bi-phone text-gold-600 text-lg block mb-1"></i>
                <span class="text-[9px] font-bold text-slate-600">Profile</span>
            </div>
            <div class="text-center p-2 rounded-xl bg-slate-50 border border-slate-200">
                <i class="bi bi-share text-gold-600 text-lg block mb-1"></i>
                <span class="text-[9px] font-bold text-slate-600">Connect</span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-3 items-center">
            <div class="flex flex-col items-center gap-2">
                <p class="text-[9px] font-bold uppercase tracking-wider text-slate-500">Example profile</p>
                @include('card-applications.partials.example-showcase', ['size' => 'compact', 'static' => true])
                <a href="{{ $exampleUrl }}" target="_blank" rel="noopener"
                   class="text-[10px] font-bold text-gold-700 hover:text-gold-600 inline-flex items-center gap-1">
                    Open live demo <i class="bi bi-box-arrow-up-right"></i>
                </a>
            </div>
            <div class="flex flex-col items-center gap-2">
                <p class="text-[9px] font-bold uppercase tracking-wider text-slate-500">Your NFC card</p>
                <img src="{{ asset('images/image.webp') }}" alt="Kimem NFC card"
                     class="w-full max-w-[140px] rounded-xl shadow-lg shadow-slate-300/60 rotate-[-5deg]">
                <p class="text-[9px] text-slate-500 text-center leading-relaxed">Shipped after you submit this form.</p>
            </div>
        </div>
    </div>
</section>
