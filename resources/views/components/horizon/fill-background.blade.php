@props([
    'image' => null,
    'opacity' => 80,
    'shade' => 40,
    'focusX' => 50,
    'focusY' => 50,
    'previewField' => null,
])

@php
    $opacity = max(0, min(100, (int) $opacity));
    $shade = max(0, min(100, (int) $shade));
    $focusX = max(0, min(100, (int) $focusX));
    $focusY = max(0, min(100, (int) $focusY));
@endphp

@if(filled($image))
    <div
        class="hz-fill"
        style="--hz-fill-opacity: {{ $opacity / 100 }}; --hz-fill-shade: {{ $shade / 100 }}; --hz-fill-x: {{ $focusX }}%; --hz-fill-y: {{ $focusY }}%;"
        aria-hidden="true"
    >
        <img src="{{ $image }}" alt="" @if($previewField) data-preview-field="{{ $previewField }}" @endif>
        <span class="hz-fill-shade"></span>
    </div>
@endif
