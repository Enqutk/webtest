{{-- What Kimem Cards delivers — shown on invite / apply flow (mobile-first) --}}
@php
    $exampleUrl = url('/card/yeabsira-endale');
@endphp

<section class="rounded-3xl border border-slate-800 bg-slate-900/90 overflow-hidden shadow-xl">
    <div class="p-4 sm:p-5 border-b border-slate-800 space-y-1">
        <div class="flex items-center gap-2 text-gold-400 text-[10px] font-bold uppercase tracking-wider">
            <i class="bi bi-lightning-charge-fill"></i> What you get
        </div>
        <h2 class="text-base sm:text-lg font-bold text-white font-cinzel">One tap. Your full professional presence.</h2>
        <p class="text-[11px] text-slate-400 leading-relaxed">
            Kimem Cards pairs a premium NFC business card with a live digital profile — photo, bio, portfolio, and contact links. Tap the card on any phone; no app needed.
        </p>
    </div>

    <div class="p-4 sm:p-5 grid grid-cols-1 sm:grid-cols-3 gap-3">
        <div class="flex gap-3 p-3 rounded-2xl bg-slate-950/70 border border-slate-800">
            <div class="w-9 h-9 rounded-xl bg-gold-500/15 border border-gold-500/30 flex items-center justify-center shrink-0">
                <i class="bi bi-phone text-gold-400"></i>
            </div>
            <div>
                <div class="text-xs font-bold text-white">1. Tap the card</div>
                <p class="text-[10px] text-slate-400 mt-0.5">Hold your NFC card near any smartphone.</p>
            </div>
        </div>
        <div class="flex gap-3 p-3 rounded-2xl bg-slate-950/70 border border-slate-800">
            <div class="w-9 h-9 rounded-xl bg-gold-500/15 border border-gold-500/30 flex items-center justify-center shrink-0">
                <i class="bi bi-globe2 text-gold-400"></i>
            </div>
            <div>
                <div class="text-xs font-bold text-white">2. Profile opens</div>
                <p class="text-[10px] text-slate-400 mt-0.5">Your photo, story, projects &amp; links load instantly.</p>
            </div>
        </div>
        <div class="flex gap-3 p-3 rounded-2xl bg-slate-950/70 border border-slate-800">
            <div class="w-9 h-9 rounded-xl bg-gold-500/15 border border-gold-500/30 flex items-center justify-center shrink-0">
                <i class="bi bi-person-check text-gold-400"></i>
            </div>
            <div>
                <div class="text-xs font-bold text-white">3. Connect &amp; share</div>
                <p class="text-[10px] text-slate-400 mt-0.5">WhatsApp, email, LinkedIn — one polished page.</p>
            </div>
        </div>
    </div>

    <div class="px-4 sm:px-5 pb-4 sm:pb-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 rounded-2xl bg-gradient-to-br from-slate-950 to-slate-900 border border-slate-800">
            <div class="flex flex-col items-center justify-center gap-2 order-2 sm:order-1">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Example finished profile</p>
                <div class="w-full flex justify-center">
                    @include('card-applications.partials.example-showcase', ['size' => 'compact', 'static' => true])
                </div>
                <a href="{{ $exampleUrl }}" target="_blank" rel="noopener"
                   class="inline-flex items-center gap-1.5 text-[11px] font-bold text-gold-400 hover:text-gold-300 transition mt-1">
                    View live example <i class="bi bi-box-arrow-up-right text-[10px]"></i>
                </a>
            </div>
            <div class="flex flex-col items-center justify-center gap-3 order-1 sm:order-2">
                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Physical NFC card</p>
                <div class="relative w-full max-w-[240px] mx-auto">
                    <div class="absolute inset-0 bg-gold-500/10 blur-3xl rounded-full scale-75"></div>
                    <img src="{{ asset('images/image.webp') }}" alt="Kimem NFC business card mockup"
                         class="relative w-full rounded-2xl shadow-2xl shadow-black/60 rotate-[-6deg] hover:rotate-0 transition-transform duration-500">
                </div>
                <p class="text-[10px] text-slate-400 text-center max-w-[220px]">
                    Brushed metal finish with embedded NFC chip — ships to you after you submit this form.
                </p>
            </div>
        </div>
    </div>
</section>
