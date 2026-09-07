{{-- Premium VIP invitation hero — white theme, mobile-first --}}
@php
    $firstName = trim(explode(' ', $invitation->client_name)[0] ?: $invitation->client_name);
    $editionKey = $invitation->card_edition ?: 'midnight_navy';
    $editionMeta = $editions[$editionKey] ?? null;
    $editionLabel = $editionMeta['name'] ?? 'Midnight Obsidian Navy';
    $editionPrice = $editionMeta['price'] ?? '1,850 ETB';
@endphp

<section class="invite-hero relative overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl shadow-slate-200/60">
    <div class="invite-hero-glow-light absolute inset-0 pointer-events-none"></div>
    <div class="invite-hero-grid-light absolute inset-0 opacity-60 pointer-events-none"></div>

    <div class="relative p-5 sm:p-7 space-y-5">
        <div class="flex flex-wrap items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-800 text-[10px] font-bold uppercase tracking-widest">
                <i class="bi bi-shield-lock-fill text-amber-600"></i> Private invitation
            </span>
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-slate-50 border border-slate-200 text-slate-500 text-[9px] font-mono tracking-wide">
                {{ $invitation->token }}
            </span>
        </div>

        <div class="space-y-2">
            <p class="text-[11px] font-medium text-amber-700/80 uppercase tracking-[0.2em]">Kimem Cards · Personal studio</p>
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 font-cinzel leading-tight">
                Welcome, {{ $firstName }}.
            </h1>
            <p class="text-sm text-slate-600 leading-relaxed max-w-xl">
                Design your NFC business card and live digital profile in a few minutes. Everything updates in the preview as you go.
            </p>
        </div>

        <div class="flex flex-wrap gap-2">
            @if($invitation->initial_role)
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200 text-[11px] text-slate-700">
                    <i class="bi bi-briefcase text-gold-600"></i> {{ $invitation->initial_role }}
                </span>
            @endif
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-amber-50 border border-amber-200 text-[11px] text-amber-900">
                <i class="bi bi-credit-card-2-front text-gold-600"></i> {{ $editionLabel }}
            </span>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-50 border border-slate-200 text-[11px] text-slate-600">
                <i class="bi bi-tag text-emerald-600"></i> {{ $editionPrice }}
            </span>
        </div>

        <div class="grid grid-cols-2 gap-2 sm:flex sm:flex-wrap">
            <button type="button"
                    @click="previewPanel = 'example'; mobilePreviewExpanded = true; showMobilePreviewModal = true"
                    class="flex items-center justify-center gap-2 py-3 px-4 rounded-2xl text-xs font-bold text-slate-700 border border-slate-200 bg-white hover:border-gold-400 hover:bg-amber-50/50 transition min-h-[48px]">
                <i class="bi bi-play-circle text-gold-600"></i> See example
            </button>
            <button type="button"
                    @click="previewPanel = 'live'; activeStep = 1; document.getElementById('invite-form-start')?.scrollIntoView({ behavior: 'smooth', block: 'start' })"
                    class="flex items-center justify-center gap-2 py-3 px-4 rounded-2xl text-xs font-extrabold text-slate-950 bg-gradient-to-r from-gold-500 to-amber-300 shadow-lg shadow-amber-200/80 min-h-[48px]">
                Start my design <i class="bi bi-arrow-right"></i>
            </button>
        </div>

        <div class="flex flex-wrap items-center gap-x-3 gap-y-1 pt-1 text-[10px] text-slate-500">
            <span class="flex items-center gap-1"><i class="bi bi-phone text-gold-600"></i> Best on mobile</span>
            <span class="hidden sm:inline w-1 h-1 rounded-full bg-slate-300"></span>
            <span class="flex items-center gap-1"><i class="bi bi-clock text-gold-600"></i> ~5 min to complete</span>
            <span class="hidden sm:inline w-1 h-1 rounded-full bg-slate-300"></span>
            <span class="flex items-center gap-1"><i class="bi bi-lock text-gold-600"></i> Link is unique to you</span>
        </div>

        <div class="flex flex-wrap gap-2 pt-2 border-t border-slate-100">
            <button type="button" @click="saveDraft()"
                    class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-[11px] font-bold border border-slate-200 bg-white text-slate-700 hover:border-gold-400 hover:bg-amber-50/60 transition min-h-[40px]">
                <i class="bi" :class="draftSaved ? 'bi-check-lg text-emerald-600' : 'bi-bookmark'"></i>
                <span x-text="draftSaved ? 'Progress saved!' : 'Save progress'"></span>
            </button>
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $kimemSupportPhone) }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-[11px] font-bold border border-slate-200 bg-white text-slate-700 hover:border-emerald-400 hover:bg-emerald-50/60 transition min-h-[40px]">
                <i class="bi bi-telephone text-emerald-600"></i> Call Kimem
            </a>
            <a href="https://wa.me/{{ $kimemSupportWhatsapp }}?text={{ urlencode('Hi Kimem Cards, I need help with my invitation link.') }}"
               target="_blank" rel="noopener"
               class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-[11px] font-bold border border-emerald-200 bg-emerald-50 text-emerald-800 hover:bg-emerald-100 transition min-h-[40px]">
                <i class="bi bi-whatsapp"></i> WhatsApp help
            </a>
        </div>
        <p x-show="draftLoaded" class="text-[10px] text-emerald-600 font-medium flex items-center gap-1">
            <i class="bi bi-arrow-counterclockwise"></i> Your saved progress was restored.
        </p>
    </div>
</section>
