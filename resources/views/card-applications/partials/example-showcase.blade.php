{{--
    Static finished-product example mockup.
    @param string $size   compact | full
    @param bool   $static When true, always visible (no Alpine panel switching)
--}}
@php
    $size = $size ?? 'full';
    $static = $static ?? false;
    $isCompact = $size === 'compact';
    $frameClass = $isCompact ? 'max-w-[220px]' : 'max-w-[300px]';
    $heroH = $isCompact ? 'h-14' : 'h-24';
    $contentPull = $isCompact ? '-mt-5' : '-mt-8';
    $pad = $isCompact ? 'px-3 pb-3' : 'px-4 pb-4';
    $scrollMax = $isCompact ? 'max-h-[240px]' : 'max-h-[480px]';
    $avatarSize = $isCompact ? 'w-11 h-11' : 'w-14 h-14';
    $websiteShow = $static ? '' : 'x-show="previewPanel === \'example\' && previewMode === \'website\'"';
    $cardShow = $static ? '' : 'x-show="previewPanel === \'example\' && previewMode === \'card\'" x-cloak';
@endphp

<!-- Example website profile — light theme -->
<div {!! $websiteShow !!} class="phone-frame border overflow-hidden {{ $frameClass }} mx-auto example-phone-light">

    <div class="relative {{ $heroH }} w-full overflow-hidden bg-gradient-to-br from-teal-50 via-white to-amber-50">
        <div class="absolute inset-0 opacity-70" style="background:radial-gradient(circle at 25% 30%, rgba(29,78,74,0.15) 0%, transparent 60%);"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-white via-transparent to-transparent"></div>
    </div>

    <div class="{{ $pad }} {{ $contentPull }} relative space-y-2 {{ $scrollMax }} overflow-y-auto text-center"
         style="background:#fffefb;color:#1b2430;font-family:Outfit,sans-serif;">

        <div class="mx-auto overflow-hidden border-2 shadow-lg relative z-10 {{ $avatarSize }} shape-squircle"
             style="border-color:#1d4e4a;background-color:#f6f3ee;">
            <div class="w-full h-full flex items-center justify-center font-bold {{ $isCompact ? 'text-sm' : 'text-base' }}" style="color:#1d4e4a;">Y</div>
        </div>

        <div>
            <span class="inline-block px-2 py-0.5 rounded-full font-bold uppercase tracking-wider border line-clamp-1 max-w-full {{ $isCompact ? 'text-[7px]' : 'text-[8px]' }}"
                  style="color:#1d4e4a;border-color:rgba(29,78,74,0.25);background-color:rgba(29,78,74,0.08);">
                Software Engineer &amp; Creator
            </span>
            <h3 class="font-bold mt-1 line-clamp-1 {{ $isCompact ? 'text-[10px]' : 'text-xs' }}" style="font-family:Fraunces,serif;color:#1b2430;">
                Yeabsira Endale Kukusha
            </h3>
            <p class="line-clamp-2 mt-0.5 {{ $isCompact ? 'text-[8px]' : 'text-[9px]' }}" style="color:#5c6570;">
                Software Engineer · Junior PM · Creator of Kimem Cards
            </p>
        </div>

        @unless($isCompact)
        <div class="space-y-1 text-left">
            @foreach (['Built Kimem Cards — NFC profiles for Ethiopia', 'Full-stack & Flutter product delivery', 'Junior PM · campus tech leadership'] as $item)
            <div class="flex items-start gap-1.5 text-[8px]" style="color:#5c6570;">
                <i class="bi bi-check-circle-fill shrink-0" style="color:#1d4e4a;"></i>
                <span class="line-clamp-1">{{ $item }}</span>
            </div>
            @endforeach
        </div>
        @endunless

        <div class="space-y-1 text-left pt-0.5">
            <div class="flex items-center justify-between font-bold uppercase {{ $isCompact ? 'text-[7px]' : 'text-[9px]' }}" style="color:#5c6570;">
                <span>Portfolio</span>
                <span style="color:#1d4e4a;">Live</span>
            </div>
            <div class="rounded-xl border p-1.5" style="background-color:#f6f3ee;border-color:#e4ded6;">
                <div class="flex items-center justify-between gap-1">
                    <span class="font-bold truncate {{ $isCompact ? 'text-[7px]' : 'text-[9px]' }}" style="color:#1b2430;">Kimem Cards Platform</span>
                    <span class="px-1 py-0.5 rounded font-mono shrink-0 {{ $isCompact ? 'text-[6px]' : 'text-[7px]' }}" style="background-color:rgba(29,78,74,0.12);color:#1d4e4a;">NFC</span>
                </div>
                @unless($isCompact)
                <p class="text-[8px] line-clamp-1 mt-0.5" style="color:#5c6570;">Smart business cards &amp; digital profiles</p>
                @endunless
            </div>
            @unless($isCompact)
            <div class="rounded-xl border p-1.5" style="background-color:#f6f3ee;border-color:#e4ded6;">
                <div class="flex items-center justify-between gap-1">
                    <span class="text-[9px] font-bold truncate" style="color:#1b2430;">Backend Engineering</span>
                    <span class="text-[7px] px-1 py-0.5 rounded font-mono shrink-0" style="background-color:rgba(29,78,74,0.12);color:#1d4e4a;">Laravel</span>
                </div>
                <p class="text-[8px] line-clamp-1 mt-0.5" style="color:#5c6570;">APIs, admin panels &amp; production systems</p>
            </div>
            @endunless
        </div>

        <div class="rounded-xl font-bold inline-block w-full shadow-md {{ $isCompact ? 'px-2 py-1.5 text-[7px]' : 'px-3 py-2 text-[9px]' }}"
             style="background-color:#1d4e4a;color:#fffefb;">
            Connect · Yeabsira
        </div>
    </div>
</div>

@if (!$static)
<!-- Example NFC card mockup -->
<div {!! $cardShow !!} class="{{ $frameClass }} mx-auto space-y-3">
    <div class="aspect-[1.586/1] rounded-2xl border shadow-xl relative flex flex-col justify-between overflow-hidden p-4 bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 border-indigo-500/30">
        <div class="flex items-center justify-between relative z-10">
            <div class="{{ $isCompact ? 'w-6 h-4' : 'w-8 h-6' }} rounded bg-gradient-to-br from-yellow-300 to-amber-500 shadow-inner"></div>
            <i class="bi bi-wifi text-white/80 rotate-90 {{ $isCompact ? 'text-sm' : 'text-lg' }}"></i>
        </div>
        <div class="space-y-0.5 relative z-10">
            <div class="font-mono tracking-widest text-slate-400 {{ $isCompact ? 'text-[7px]' : 'text-[8px]' }}">KIMEM TOUCHLESS ID</div>
            <div class="font-extrabold text-white tracking-wide font-cinzel truncate {{ $isCompact ? 'text-[10px]' : 'text-sm' }}">Yeabsira Endale Kukusha</div>
            <div class="font-medium text-gold-400 truncate {{ $isCompact ? 'text-[8px]' : 'text-[9px]' }}">Software Engineer &amp; Creator</div>
        </div>
        <div class="flex items-center justify-between border-t border-white/10 pt-1 relative z-10">
            <span class="font-bold font-cinzel text-white/70 {{ $isCompact ? 'text-[7px]' : 'text-[9px]' }}">KIMEM CARDS</span>
            <i class="bi bi-qr-code text-white {{ $isCompact ? 'text-[10px]' : 'text-xs' }}"></i>
        </div>
    </div>

    @unless($isCompact)
    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3 text-center">
        <p class="text-[9px] font-bold uppercase tracking-wider text-slate-500 mb-2">Physical card you receive</p>
        <img src="{{ asset('images/image.webp') }}" alt="Kimem NFC business card" class="mx-auto w-full max-w-[200px] rounded-xl shadow-lg rotate-[-4deg]">
    </div>
    @endunless
</div>
@endif
