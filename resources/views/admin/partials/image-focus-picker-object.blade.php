{{--
    For Alpine x-for loops. Requires scope methods from image-focus-alpine mixin.
    - {{ $object }}: object variable name (e.g. panel)
    - {{ $previewExpr }}: Alpine expression for preview URL
    - {{ $namePrefix }}: form field prefix e.g. panels[0]
--}}
@php
    $xKey = $xKey ?? 'image_focus_x';
    $yKey = $yKey ?? 'image_focus_y';
@endphp

<div class="space-y-3 pt-2 border-t border-slate-100">
    <div>
        <label class="block text-xs font-bold text-slate-700">Photo crop focus</label>
        <p class="text-[11px] text-slate-500 mt-1">Click the preview or use the sliders to choose which part of the photo stays visible.</p>
    </div>

    <div
        x-show="{{ $previewExpr }}"
        x-cloak
        class="relative aspect-[4/3] max-h-48 bg-slate-100 rounded-xl overflow-hidden border border-slate-200 cursor-crosshair"
        @click="imageFocusOnObject($event, {{ $object }}, '{{ $xKey }}', '{{ $yKey }}')"
    >
        <img
            :src="{{ $previewExpr }}"
            alt="Crop preview"
            class="w-full h-full object-cover pointer-events-none select-none"
            :style="'object-position:' + ({{ $object }}.{{ $xKey }} ?? 50) + '% ' + ({{ $object }}.{{ $yKey }} ?? 50) + '%'"
        >
        <span
            class="absolute w-4 h-4 -translate-x-1/2 -translate-y-1/2 rounded-full border-2 border-white bg-brand-600 shadow pointer-events-none"
            :style="'left:' + ({{ $object }}.{{ $xKey }} ?? 50) + '%; top:' + ({{ $object }}.{{ $yKey }} ?? 50) + '%'"
        ></span>
    </div>

    <div class="flex flex-wrap gap-2">
        <button type="button" @click="setFocusPresetOnObject({{ $object }}, 50, 25, '{{ $xKey }}', '{{ $yKey }}')" class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-[11px] font-bold text-slate-700">Face / top</button>
        <button type="button" @click="setFocusPresetOnObject({{ $object }}, 50, 50, '{{ $xKey }}', '{{ $yKey }}')" class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-[11px] font-bold text-slate-700">Center</button>
        <button type="button" @click="setFocusPresetOnObject({{ $object }}, 50, 75, '{{ $xKey }}', '{{ $yKey }}')" class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-[11px] font-bold text-slate-700">Lower</button>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div class="space-y-1.5">
            <label class="block text-[11px] font-bold text-slate-600">Horizontal focus</label>
            <input type="range" min="0" max="100" x-model.number="{{ $object }}.{{ $xKey }}" class="w-full accent-brand-600">
        </div>
        <div class="space-y-1.5">
            <label class="block text-[11px] font-bold text-slate-600">Vertical focus</label>
            <input type="range" min="0" max="100" x-model.number="{{ $object }}.{{ $yKey }}" class="w-full accent-brand-600">
        </div>
    </div>

    <input type="hidden" :name="'{{ $namePrefix }}[' + {{ $indexVar ?? '0' }} + '][{{ $xKey }}]'" :value="{{ $object }}.{{ $xKey }} ?? 50">
    <input type="hidden" :name="'{{ $namePrefix }}[' + {{ $indexVar ?? '0' }} + '][{{ $yKey }}]'" :value="{{ $object }}.{{ $yKey }} ?? 50">
</div>
