@props([
    'as' => 'span',
    'name' => null,
])

@php
    $brand = trim((string) ($name ?? ($data['siteName'] ?? config('app.name', 'Site'))));
    $parts = preg_split('/\s+/', $brand, 2) ?: [$brand];
    $first = $parts[0] ?? $brand;
    $rest = $parts[1] ?? null;
@endphp

<{{ $as }} {{ $attributes }}>
    {{ $first }}@if($rest) <span>{{ $rest }}</span>@endif
</{{ $as }}>
