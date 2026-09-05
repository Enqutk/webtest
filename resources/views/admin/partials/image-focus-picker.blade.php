{{--
    Requires Alpine scope variables:
    - {{ $focusX }}, {{ $focusY }}, {{ $previewUrl }}
    Optional: {{ $onPick ?? 'onImagePick($event)' }}
    Hidden input names: {{ $nameX ?? 'image_focus_x' }}, {{ $nameY ?? 'image_focus_y' }}
--}}
@php
    $nameX = $nameX ?? 'image_focus_x';
    $nameY = $nameY ?? 'image_focus_y';
    $onPick = $onPick ?? 'onImagePick($event)';
@endphp

<div class="space-y-3 pt-2 border-t border-slate-100">
    <div>
        <label class="block text-xs font-bold text-slate-700">Photo crop focus</label>
        <p class="text-[11px] text-slate-500 mt-1">Click the preview or use the sliders to choose which part of the photo stays visible.</p>
    </div>

    <div
        x-show="{{ $previewUrl }}"
        x-cloak
        class="relative aspect-[4/3] max-h-56 bg-slate-100 rounded-xl overflow-hidden border border-slate-200 cursor-crosshair"
        @click="imageFocusFromClick($event, '{{ $focusX }}', '{{ $focusY }}')"
    >
        <img
            :src="{{ $previewUrl }}"
            alt="Crop preview"
            class="w-full h-full object-cover pointer-events-none select-none"
            :style="'object-position:' + {{ $focusX }} + '% ' + {{ $focusY }} + '%'"
        >
        <span
            class="absolute w-4 h-4 -translate-x-1/2 -translate-y-1/2 rounded-full border-2 border-white bg-brand-600 shadow pointer-events-none"
            :style="'left:' + {{ $focusX }} + '%; top:' + {{ $focusY }} + '%'"
        ></span>
    </div>

    <div class="flex flex-wrap gap-2">
        <button type="button" @click="setImageFocusPreset(50, 25, '{{ $focusX }}', '{{ $focusY }}')" class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-[11px] font-bold text-slate-700">Face / top</button>
        <button type="button" @click="setImageFocusPreset(50, 50, '{{ $focusX }}', '{{ $focusY }}')" class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-[11px] font-bold text-slate-700">Center</button>
        <button type="button" @click="setImageFocusPreset(50, 75, '{{ $focusX }}', '{{ $focusY }}')" class="px-2.5 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-[11px] font-bold text-slate-700">Lower</button>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div class="space-y-1.5">
            <label class="block text-[11px] font-bold text-slate-600">Horizontal focus</label>
            <input type="range" min="0" max="100" x-model.number="{{ $focusX }}" class="w-full accent-brand-600">
        </div>
        <div class="space-y-1.5">
            <label class="block text-[11px] font-bold text-slate-600">Vertical focus</label>
            <input type="range" min="0" max="100" x-model.number="{{ $focusY }}" class="w-full accent-brand-600">
        </div>
    </div>

    <input type="hidden" name="{{ $nameX }}" :value="{{ $focusX }}">
    <input type="hidden" name="{{ $nameY }}" :value="{{ $focusY }}">
</div>
