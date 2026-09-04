{{-- Requires Alpine: bgColor, surfaceColor, textColor, mutedColor, lineColor, accentColor, accentSecondary, applyThemePreset() --}}

<div class="space-y-3">
    <div class="flex items-center justify-between gap-3 flex-wrap">
        <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider">1-Click Theme & Background Presets</label>
        <span class="text-[11px] text-slate-500">Instantly applies coordinated canvas, surface, and text colors</span>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
        <button type="button" @click="applyThemePreset('enku-dark')"
                :class="bgColor === '#0b0f19' ? 'ring-2 ring-emerald-500 border-emerald-500 shadow-md' : 'border-slate-800 hover:border-slate-600'"
                class="p-3.5 rounded-xl border bg-[#0b0f19] text-left transition">
            <div class="flex items-center gap-2 mb-2">
                <span class="w-3 h-3 rounded-full bg-emerald-400"></span>
                <span class="w-3 h-3 rounded-full bg-[#111827] border border-slate-700"></span>
                <span class="w-3 h-3 rounded-full bg-amber-400"></span>
            </div>
            <span class="text-xs font-bold text-white block">Obsidian Dark</span>
            <span class="text-[10px] text-emerald-400 font-mono block">Enku Black Style</span>
        </button>

        <button type="button" @click="applyThemePreset('pure-black')"
                :class="bgColor === '#000000' ? 'ring-2 ring-emerald-500 border-emerald-500 shadow-md' : 'border-slate-800 hover:border-slate-600'"
                class="p-3.5 rounded-xl border bg-black text-left transition">
            <div class="flex items-center gap-2 mb-2">
                <span class="w-3 h-3 rounded-full bg-white"></span>
                <span class="w-3 h-3 rounded-full bg-[#0a0a0a] border border-slate-800"></span>
                <span class="w-3 h-3 rounded-full bg-amber-400"></span>
            </div>
            <span class="text-xs font-bold text-white block">Pitch Black</span>
            <span class="text-[10px] text-slate-400 font-mono block">Pure OLED Mode</span>
        </button>

        <button type="button" @click="applyThemePreset('luxury-navy')"
                :class="bgColor === '#061122' ? 'ring-2 ring-emerald-500 border-emerald-500 shadow-md' : 'border-slate-800 hover:border-slate-600'"
                class="p-3.5 rounded-xl border bg-[#061122] text-left transition">
            <div class="flex items-center gap-2 mb-2">
                <span class="w-3 h-3 rounded-full bg-[#d4af37]"></span>
                <span class="w-3 h-3 rounded-full bg-[#0b1d3a] border border-blue-900"></span>
                <span class="w-3 h-3 rounded-full bg-white"></span>
            </div>
            <span class="text-xs font-bold text-white block">Midnight Navy</span>
            <span class="text-[10px] text-sky-300 font-mono block">Deep Blue & Gold</span>
        </button>

        <button type="button" @click="applyThemePreset('executive-slate')"
                :class="bgColor === '#f8fafc' ? 'ring-2 ring-emerald-500 border-emerald-500 shadow-md' : 'border-slate-200 hover:border-slate-300'"
                class="p-3.5 rounded-xl border bg-slate-50 text-left transition">
            <div class="flex items-center gap-2 mb-2">
                <span class="w-3 h-3 rounded-full bg-[#0f766e]"></span>
                <span class="w-3 h-3 rounded-full bg-white border border-slate-300"></span>
                <span class="w-3 h-3 rounded-full bg-slate-900"></span>
            </div>
            <span class="text-xs font-bold text-slate-900 block">Clean Slate</span>
            <span class="text-[10px] text-teal-600 font-mono block">Maji Works Style</span>
        </button>

        <button type="button" @click="applyThemePreset('warm-ivory')"
                :class="bgColor === '#fdfbf7' ? 'ring-2 ring-emerald-500 border-emerald-500 shadow-md' : 'border-slate-200 hover:border-slate-300'"
                class="p-3.5 rounded-xl border bg-[#fdfbf7] text-left transition">
            <div class="flex items-center gap-2 mb-2">
                <span class="w-3 h-3 rounded-full bg-[#ea580c]"></span>
                <span class="w-3 h-3 rounded-full bg-white border border-stone-300"></span>
                <span class="w-3 h-3 rounded-full bg-stone-900"></span>
            </div>
            <span class="text-xs font-bold text-stone-900 block">Warm Ivory</span>
            <span class="text-[10px] text-amber-700 font-mono block">Linen / Sand</span>
        </button>
    </div>
</div>

<div class="pt-4 border-t border-slate-100 space-y-4">
    <div class="flex items-center justify-between gap-3 flex-wrap">
        <label class="block text-xs font-bold text-slate-800 uppercase tracking-wider">Custom Color Palette & Swatch Picker</label>
        <span class="text-[11px] text-slate-500">Click any color dot to instantly apply or pick custom hex</span>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="space-y-2 p-3.5 rounded-xl border border-slate-200/80 bg-slate-50/50">
            <label class="block text-xs font-bold text-slate-700 flex items-center justify-between">
                <span>Main Background Canvas</span>
                <span class="text-[10px] font-mono text-slate-500">theme[bg]</span>
            </label>
            <div class="flex items-center gap-2.5">
                <input type="color" name="theme[bg]" x-model="bgColor" class="w-10 h-9 p-0.5 rounded-xl border border-slate-300 cursor-pointer bg-white shadow-sm shrink-0">
                <input type="text" x-model="bgColor" class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-900 shadow-sm">
            </div>
            <div class="flex items-center gap-1.5 pt-1 flex-wrap">
                <span class="text-[10px] text-slate-400 font-semibold mr-1">Presets:</span>
                @foreach(['#0b0f19', '#000000', '#061122', '#0f172a', '#18181b', '#f8fafc', '#fdfbf7', '#ffffff'] as $c)
                    <button type="button" @click="bgColor = '{{ $c }}'" title="{{ $c }}"
                            class="w-5 h-5 rounded-full border border-slate-300 shadow-sm transition hover:scale-125 focus:outline-none"
                            :class="bgColor === '{{ $c }}' ? 'ring-2 ring-brand-500 scale-110' : ''"
                            style="background: {{ $c }}"></button>
                @endforeach
            </div>
        </div>

        <div class="space-y-2 p-3.5 rounded-xl border border-slate-200/80 bg-slate-50/50">
            <label class="block text-xs font-bold text-slate-700 flex items-center justify-between">
                <span>Card & Section Surface</span>
                <span class="text-[10px] font-mono text-slate-500">theme[surface]</span>
            </label>
            <div class="flex items-center gap-2.5">
                <input type="color" name="theme[surface]" x-model="surfaceColor" class="w-10 h-9 p-0.5 rounded-xl border border-slate-300 cursor-pointer bg-white shadow-sm shrink-0">
                <input type="text" x-model="surfaceColor" class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-900 shadow-sm">
            </div>
            <div class="flex items-center gap-1.5 pt-1 flex-wrap">
                <span class="text-[10px] text-slate-400 font-semibold mr-1">Presets:</span>
                @foreach(['#111827', '#0a0a0a', '#0b1d3a', '#1e293b', '#27272a', '#ffffff', '#f1f5f9', '#f8fafc'] as $c)
                    <button type="button" @click="surfaceColor = '{{ $c }}'" title="{{ $c }}"
                            class="w-5 h-5 rounded-full border border-slate-300 shadow-sm transition hover:scale-125 focus:outline-none"
                            :class="surfaceColor === '{{ $c }}' ? 'ring-2 ring-brand-500 scale-110' : ''"
                            style="background: {{ $c }}"></button>
                @endforeach
            </div>
        </div>

        <div class="space-y-2 p-3.5 rounded-xl border border-slate-200/80 bg-slate-50/50">
            <label class="block text-xs font-bold text-slate-700 flex items-center justify-between">
                <span>Primary Heading & Text</span>
                <span class="text-[10px] font-mono text-slate-500">theme[ink]</span>
            </label>
            <div class="flex items-center gap-2.5">
                <input type="color" name="theme[ink]" x-model="textColor" class="w-10 h-9 p-0.5 rounded-xl border border-slate-300 cursor-pointer bg-white shadow-sm shrink-0">
                <input type="text" x-model="textColor" class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-900 shadow-sm">
            </div>
            <div class="flex items-center gap-1.5 pt-1 flex-wrap">
                <span class="text-[10px] text-slate-400 font-semibold mr-1">Presets:</span>
                @foreach(['#ffffff', '#f9fafb', '#f3f4f6', '#e2e8f0', '#10211f', '#0f172a', '#1c1917', '#000000'] as $c)
                    <button type="button" @click="textColor = '{{ $c }}'" title="{{ $c }}"
                            class="w-5 h-5 rounded-full border border-slate-300 shadow-sm transition hover:scale-125 focus:outline-none"
                            :class="textColor === '{{ $c }}' ? 'ring-2 ring-brand-500 scale-110' : ''"
                            style="background: {{ $c }}"></button>
                @endforeach
            </div>
        </div>

        <div class="space-y-2 p-3.5 rounded-xl border border-slate-200/80 bg-slate-50/50">
            <label class="block text-xs font-bold text-slate-700 flex items-center justify-between">
                <span>Muted / Subtitle Text</span>
                <span class="text-[10px] font-mono text-slate-500">theme[muted]</span>
            </label>
            <div class="flex items-center gap-2.5">
                <input type="color" name="theme[muted]" x-model="mutedColor" class="w-10 h-9 p-0.5 rounded-xl border border-slate-300 cursor-pointer bg-white shadow-sm shrink-0">
                <input type="text" x-model="mutedColor" class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-900 shadow-sm">
            </div>
            <div class="flex items-center gap-1.5 pt-1 flex-wrap">
                <span class="text-[10px] text-slate-400 font-semibold mr-1">Presets:</span>
                @foreach(['#9ca3af', '#94a3b8', '#a1a1aa', '#64748b', '#5a6b68', '#78716c', '#475569', '#334155'] as $c)
                    <button type="button" @click="mutedColor = '{{ $c }}'" title="{{ $c }}"
                            class="w-5 h-5 rounded-full border border-slate-300 shadow-sm transition hover:scale-125 focus:outline-none"
                            :class="mutedColor === '{{ $c }}' ? 'ring-2 ring-brand-500 scale-110' : ''"
                            style="background: {{ $c }}"></button>
                @endforeach
            </div>
        </div>

        <div class="space-y-2 p-3.5 rounded-xl border border-slate-200/80 bg-slate-50/50">
            <label class="block text-xs font-bold text-slate-700 flex items-center justify-between">
                <span>Borders & Divider Lines</span>
                <span class="text-[10px] font-mono text-slate-500">theme[line]</span>
            </label>
            <div class="flex items-center gap-2.5">
                <input type="color" name="theme[line]" x-model="lineColor" class="w-10 h-9 p-0.5 rounded-xl border border-slate-300 cursor-pointer bg-white shadow-sm shrink-0">
                <input type="text" x-model="lineColor" class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-900 shadow-sm">
            </div>
            <div class="flex items-center gap-1.5 pt-1 flex-wrap">
                <span class="text-[10px] text-slate-400 font-semibold mr-1">Presets:</span>
                @foreach(['#1f2937', '#27272a', '#1e293b', '#334155', '#d7e0dd', '#e2e8f0', '#e5e7eb', '#e7e5e4'] as $c)
                    <button type="button" @click="lineColor = '{{ $c }}'" title="{{ $c }}"
                            class="w-5 h-5 rounded-full border border-slate-300 shadow-sm transition hover:scale-125 focus:outline-none"
                            :class="lineColor === '{{ $c }}' ? 'ring-2 ring-brand-500 scale-110' : ''"
                            style="background: {{ $c }}"></button>
                @endforeach
            </div>
        </div>

        <div class="space-y-2 p-3.5 rounded-xl border border-slate-200/80 bg-slate-50/50">
            <label class="block text-xs font-bold text-slate-700 flex items-center justify-between">
                <span>Primary Brand Accent</span>
                <span class="text-[10px] font-mono text-slate-500">theme[accent]</span>
            </label>
            <div class="flex items-center gap-2.5">
                <input type="color" name="theme[accent]" x-model="accentColor" class="w-10 h-9 p-0.5 rounded-xl border border-slate-300 cursor-pointer bg-white shadow-sm shrink-0">
                <input type="text" x-model="accentColor" class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-900 shadow-sm">
            </div>
            <div class="flex items-center gap-1.5 pt-1 flex-wrap">
                <span class="text-[10px] text-slate-400 font-semibold mr-1">Presets:</span>
                @foreach(['#00e769', '#d4af37', '#38bdf8', '#8b5cf6', '#f43f5e', '#f97316', '#2563eb', '#ea580c', '#0f766e'] as $c)
                    <button type="button" @click="accentColor = '{{ $c }}'" title="{{ $c }}"
                            class="w-5 h-5 rounded-full border border-slate-300 shadow-sm transition hover:scale-125 focus:outline-none"
                            :class="accentColor === '{{ $c }}' ? 'ring-2 ring-brand-500 scale-110' : ''"
                            style="background: {{ $c }}"></button>
                @endforeach
            </div>
        </div>

        <div class="space-y-2 p-3.5 rounded-xl border border-slate-200/80 bg-slate-50/50">
            <label class="block text-xs font-bold text-slate-700 flex items-center justify-between">
                <span>Secondary Accent Color</span>
                <span class="text-[10px] font-mono text-slate-500">theme[accent_secondary]</span>
            </label>
            <div class="flex items-center gap-2.5">
                <input type="color" name="theme[accent_secondary]" x-model="accentSecondary" class="w-10 h-9 p-0.5 rounded-xl border border-slate-300 cursor-pointer bg-white shadow-sm shrink-0">
                <input type="text" x-model="accentSecondary" class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-xl text-xs font-mono text-slate-900 shadow-sm">
            </div>
            <div class="flex items-center gap-1.5 pt-1 flex-wrap">
                <span class="text-[10px] text-slate-400 font-semibold mr-1">Presets:</span>
                @foreach(['#0f766e', '#ca8a04', '#0284c7', '#7c3aed', '#e11d48', '#ea580c', '#1d4ed8', '#0b5f58'] as $c)
                    <button type="button" @click="accentSecondary = '{{ $c }}'" title="{{ $c }}"
                            class="w-5 h-5 rounded-full border border-slate-300 shadow-sm transition hover:scale-125 focus:outline-none"
                            :class="accentSecondary === '{{ $c }}' ? 'ring-2 ring-brand-500 scale-110' : ''"
                            style="background: {{ $c }}"></button>
                @endforeach
            </div>
        </div>
    </div>
</div>
