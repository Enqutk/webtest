@php
    $bg = $section ?? [];
    $bgUrl = \App\Models\Organization::themeFileUrl($bg['background_image'] ?? null);
    $opacity = (int) ($bg['background_opacity'] ?? 80);
    $shade = (int) ($bg['background_shade'] ?? 40);
    $focusX = (int) ($bg['background_focus_x'] ?? 50);
    $focusY = (int) ($bg['background_focus_y'] ?? 50);
@endphp

<div class="space-y-3 pt-4 border-t border-slate-100">
    <div>
        <h4 class="text-xs font-bold text-slate-800">Background photo</h4>
        <p class="text-[11px] text-slate-500 mt-0.5">The picture covers this whole section. Raise the strength until it fills the area. Lower it to let the page color show through. Shade keeps the words readable.</p>
    </div>

    @if($bgUrl)
        <img src="{{ $bgUrl }}" alt="" class="h-32 w-full object-cover rounded-xl border border-slate-200">
    @endif

    <input type="file" name="background_image" accept="image/*"
        onchange="if (this.files[0] && window.AdminPreview) { var form = this.closest('form'); var section = form ? form.querySelector('[name=section]') : null; if (section) { window.AdminPreview.pushField(section.value, 'background_image', URL.createObjectURL(this.files[0])); } }"
        class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">

    @if($bgUrl)
        <label class="flex items-center gap-2 text-[11px] font-semibold text-rose-700">
            <input type="checkbox" name="remove_background_image" value="1" class="rounded text-rose-600">
            Remove this background photo on save
        </label>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <label class="space-y-1.5">
            <span class="flex items-center justify-between text-xs font-bold text-slate-700">
                Photo strength
                <output class="font-mono text-brand-700">{{ $opacity }}%</output>
            </span>
            <input type="range" name="background_opacity" min="0" max="100" value="{{ $opacity }}"
                oninput="this.previousElementSibling.querySelector('output').value = this.value + '%'"
                class="w-full accent-brand-600">
        </label>
        <label class="space-y-1.5">
            <span class="flex items-center justify-between text-xs font-bold text-slate-700">
                Shade over the photo
                <output class="font-mono text-brand-700">{{ $shade }}%</output>
            </span>
            <input type="range" name="background_shade" min="0" max="100" value="{{ $shade }}"
                oninput="this.previousElementSibling.querySelector('output').value = this.value + '%'"
                class="w-full accent-brand-600">
        </label>
        <label class="space-y-1.5">
            <span class="flex items-center justify-between text-xs font-bold text-slate-700">
                Horizontal focus
                <output class="font-mono text-brand-700">{{ $focusX }}%</output>
            </span>
            <input type="range" name="background_focus_x" min="0" max="100" value="{{ $focusX }}"
                oninput="this.previousElementSibling.querySelector('output').value = this.value + '%'"
                class="w-full accent-brand-600">
        </label>
        <label class="space-y-1.5">
            <span class="flex items-center justify-between text-xs font-bold text-slate-700">
                Vertical focus
                <output class="font-mono text-brand-700">{{ $focusY }}%</output>
            </span>
            <input type="range" name="background_focus_y" min="0" max="100" value="{{ $focusY }}"
                oninput="this.previousElementSibling.querySelector('output').value = this.value + '%'"
                class="w-full accent-brand-600">
        </label>
    </div>
</div>
