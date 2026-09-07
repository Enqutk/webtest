{{--
    Live outcome preview — must be inside apply page Alpine scope.
    @param string $size  compact | full
--}}
@php
    $size = $size ?? 'full';
    $isCompact = $size === 'compact';
    $frameClass = $isCompact ? 'max-w-[220px]' : 'max-w-[300px]';
    $heroH = $isCompact ? 'h-16' : 'h-28';
    $contentPull = $isCompact ? '-mt-6' : '-mt-10';
    $pad = $isCompact ? 'px-3 pb-3' : 'px-4 pb-4';
    $scrollMax = $isCompact ? 'max-h-[220px]' : 'max-h-[460px]';
    $avatarSize = $isCompact ? 'w-12 h-12' : 'w-16 h-16';
    $heroIcon = $isCompact ? 'text-lg' : 'text-2xl';
    $roleBadge = $isCompact ? 'text-[7px]' : 'text-[8px]';
    $nameSize = $isCompact ? 'text-[10px]' : 'text-xs';
    $taglineSize = $isCompact ? 'text-[8px]' : 'text-[9px]';
    $highlightSize = $isCompact ? 'text-[7px]' : 'text-[8px]';
    $sectionLabel = $isCompact ? 'text-[7px]' : 'text-[9px]';
    $projTitle = $isCompact ? 'text-[7px]' : 'text-[9px]';
    $projTag = $isCompact ? 'text-[6px]' : 'text-[7px]';
    $ctaPad = $isCompact ? 'px-2 py-1.5 text-[7px]' : 'px-3 py-2 text-[9px]';
    $cardPad = $isCompact ? 'p-3' : 'p-5';
    $chipSize = $isCompact ? 'w-6 h-4' : 'w-8 h-6';
    $wifiSize = $isCompact ? 'text-sm' : 'text-lg';
    $cardLabel = $isCompact ? 'text-[7px]' : 'text-[8px]';
    $cardName = $isCompact ? 'text-[10px]' : 'text-sm';
    $cardRole = $isCompact ? 'text-[8px]' : 'text-[9px]';
    $cardFooter = $isCompact ? 'text-[7px]' : 'text-[9px]';
    $qrSize = $isCompact ? 'text-[10px]' : 'text-xs';
@endphp

<!-- Website preview -->
<div x-show="previewMode === 'website'" class="phone-frame border overflow-hidden {{ $frameClass }} mx-auto"
     :style="{ backgroundColor: bg_color, borderColor: line_color, fontFamily: font_body, color: text_color }">

    <div class="relative {{ $heroH }} w-full bg-slate-950 overflow-hidden">
        <template x-if="heroPreview">
            <img :src="heroPreview" class="w-full h-full object-cover" alt="">
        </template>
        <template x-if="!heroPreview">
            <div class="w-full h-full flex items-center justify-center" :style="{ backgroundColor: surface_color }">
                <i class="bi bi-image text-slate-700 {{ $heroIcon }}"></i>
            </div>
        </template>
        <div class="absolute inset-0" :style="{ background: 'linear-gradient(to top, ' + bg_color + ', transparent)' }"></div>
    </div>

    <div class="{{ $pad }} {{ $contentPull }} relative space-y-2 {{ $scrollMax }} overflow-y-auto text-center">
        <div class="mx-auto overflow-hidden border-2 shadow-2xl relative z-10 {{ $avatarSize }}"
             :class="'shape-' + image_shape" :style="{ borderColor: accent_color, backgroundColor: surface_color }">
            <template x-if="photoPreview"><img :src="photoPreview" class="w-full h-full object-cover" alt=""></template>
            <template x-if="!photoPreview">
                <div class="w-full h-full flex items-center justify-center font-bold text-sm" :style="{ color: muted_color }" x-text="name ? name.charAt(0) : '?'"></div>
            </template>
        </div>

        <div>
            <span class="inline-block px-2 py-0.5 rounded-full font-bold uppercase tracking-wider border line-clamp-1 max-w-full {{ $roleBadge }}"
                  :style="{ color: accent_color, borderColor: accent_dark + '40', backgroundColor: accent_dark + '20' }" x-text="role_title"></span>
            <h3 class="font-bold mt-1 line-clamp-1 {{ $nameSize }}" :style="{ fontFamily: font_display, color: text_color }" x-text="name"></h3>
            <p class="line-clamp-2 mt-0.5 {{ $taglineSize }}" :style="{ color: muted_color }" x-text="tagline"></p>
        </div>

        <template x-if="highlight1 || highlight2 || highlight3">
            <div class="space-y-1 text-left">
                <template x-if="highlight1">
                    <div class="flex items-start gap-1.5 text-left {{ $highlightSize }}" :style="{ color: muted_color }">
                        <i class="bi bi-check-circle-fill shrink-0" :style="{ color: accent_color }"></i>
                        <span class="line-clamp-1" x-text="highlight1"></span>
                    </div>
                </template>
                <template x-if="highlight2">
                    <div class="flex items-start gap-1.5 text-left {{ $highlightSize }}" :style="{ color: muted_color }">
                        <i class="bi bi-check-circle-fill shrink-0" :style="{ color: accent_color }"></i>
                        <span class="line-clamp-1" x-text="highlight2"></span>
                    </div>
                </template>
                @if (!$isCompact)
                <template x-if="highlight3">
                    <div class="flex items-start gap-1.5 text-left text-[8px]" :style="{ color: muted_color }">
                        <i class="bi bi-check-circle-fill shrink-0" :style="{ color: accent_color }"></i>
                        <span class="line-clamp-1" x-text="highlight3"></span>
                    </div>
                </template>
                @endif
            </div>
        </template>

        <div class="space-y-1 text-left pt-0.5">
            <div class="flex items-center justify-between font-bold uppercase {{ $sectionLabel }}" :style="{ color: muted_color }">
                <span>Portfolio</span>
                <span :style="{ color: accent_color }">Live</span>
            </div>
            <template x-if="proj1_title">
                <div class="rounded-xl border p-1.5" :style="{ backgroundColor: surface_color, borderColor: line_color }">
                    <div class="flex items-center justify-between gap-1">
                        <span class="font-bold truncate {{ $projTitle }}" :style="{ color: text_color }" x-text="proj1_title"></span>
                        <span class="px-1 py-0.5 rounded font-mono shrink-0 {{ $projTag }}" :style="{ backgroundColor: accent_dark + '30', color: accent_color }" x-text="proj1_tag"></span>
                    </div>
                    @if (!$isCompact)
                    <p class="text-[8px] line-clamp-1 mt-0.5" :style="{ color: muted_color }" x-text="proj1_desc"></p>
                    @endif
                </div>
            </template>
            @if (!$isCompact)
            <template x-if="proj2_title">
                <div class="rounded-xl border p-1.5" :style="{ backgroundColor: surface_color, borderColor: line_color }">
                    <div class="flex items-center justify-between gap-1">
                        <span class="text-[9px] font-bold truncate" :style="{ color: text_color }" x-text="proj2_title"></span>
                        <span class="text-[7px] px-1 py-0.5 rounded font-mono shrink-0" :style="{ backgroundColor: accent_dark + '30', color: accent_color }" x-text="proj2_tag"></span>
                    </div>
                    <p class="text-[8px] line-clamp-1 mt-0.5" :style="{ color: muted_color }" x-text="proj2_desc"></p>
                </div>
            </template>
            <template x-if="proj3_title">
                <div class="rounded-xl border p-1.5" :style="{ backgroundColor: surface_color, borderColor: line_color }">
                    <div class="flex items-center justify-between gap-1">
                        <span class="text-[9px] font-bold truncate" :style="{ color: text_color }" x-text="proj3_title"></span>
                        <span class="text-[7px] px-1 py-0.5 rounded font-mono shrink-0" :style="{ backgroundColor: accent_dark + '30', color: accent_color }" x-text="proj3_tag"></span>
                    </div>
                    <p class="text-[8px] line-clamp-1 mt-0.5" :style="{ color: muted_color }" x-text="proj3_desc"></p>
                </div>
            </template>
            @endif
        </div>

        <div class="rounded-xl font-bold text-slate-950 inline-block w-full shadow-lg {{ $ctaPad }}"
             :style="{ backgroundColor: accent_color }">
            Connect · <span x-text="name ? name.split(' ')[0] : 'You'"></span>
        </div>
    </div>
</div>

<!-- NFC card preview -->
<div x-show="previewMode === 'card'" class="{{ $frameClass }} mx-auto" x-cloak>
    <div :class="{
            'bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 border-indigo-500/30': card_edition === 'midnight_navy',
            'bg-gradient-to-br from-amber-950 via-yellow-900 to-stone-900 border-amber-500/40': card_edition === 'brushed_gold',
            'bg-gradient-to-br from-zinc-950 via-neutral-900 to-black border-zinc-700/50': card_edition === 'executive_black'
         }"
         class="aspect-[1.586/1] rounded-2xl border shadow-2xl relative flex flex-col justify-between overflow-hidden {{ $cardPad }}">
        <div class="flex items-center justify-between relative z-10">
            <div class="{{ $chipSize }} rounded bg-gradient-to-br from-yellow-300 to-amber-500 shadow-inner"></div>
            <i class="bi bi-wifi text-white/80 rotate-90 {{ $wifiSize }}"></i>
        </div>
        <div class="space-y-0.5 relative z-10">
            <div class="font-mono tracking-widest text-slate-400 {{ $cardLabel }}">KIMEM TOUCHLESS ID</div>
            <div class="font-extrabold text-white tracking-wide font-cinzel truncate {{ $cardName }}" x-text="name"></div>
            <div class="font-medium text-gold-400 truncate {{ $cardRole }}" x-text="role_title"></div>
        </div>
        <div class="flex items-center justify-between border-t border-white/10 pt-1 relative z-10">
            <span class="font-bold font-cinzel text-white/70 {{ $cardFooter }}">KIMEM CARDS</span>
            <i class="bi bi-qr-code text-white {{ $qrSize }}"></i>
        </div>
    </div>
</div>
