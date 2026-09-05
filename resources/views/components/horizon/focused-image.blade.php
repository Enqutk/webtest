@props([
    'src',
    'alt' => '',
    'focusX' => 50,
    'focusY' => 50,
    'extraStyle' => '',
])

<img
    {{ $attributes->merge(['src' => $src, 'alt' => $alt]) }}
    style="{{ \App\Support\ImageFocus::style($focusX, $focusY, $extraStyle) }}"
>
