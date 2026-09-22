@props([
    'about' => [],
    'config' => [],
])

@php
    $cfg = is_array($config) ? $config : [];
    $about = is_array($about) ? $about : [];
    $eyebrow = $about['subtitle'] ?? ($cfg['eyebrow'] ?? '');
    $title = $about['title'] ?? ($cfg['title'] ?? '');
    $copy = $about['description'] ?? '';
    $points = collect($about['points'] ?? $cfg['points'] ?? [])->filter(fn ($point) => filled($point['title'] ?? null) || filled($point['description'] ?? null));
    $background = \App\Models\Organization::themeFileUrl($cfg['background_image'] ?? null);
@endphp

<section class="cm-block cm-about" id="about">
    <x-horizon.fill-background
        :image="$background"
        :opacity="$cfg['background_opacity'] ?? 80"
        :shade="$cfg['background_shade'] ?? 40"
        :focus-x="$cfg['background_focus_x'] ?? 50"
        :focus-y="$cfg['background_focus_y'] ?? 50"
    />
    <div class="container cm-inner">
        <div class="cm-about-grid">
            @if($eyebrow)
                <p class="cm-kicker" data-preview-field="eyebrow" {!! \App\Support\AdminPreviewAttrs::html('about', 'eyebrow', 'Edit Eyebrow') !!}>{{ $eyebrow }}</p>
            @endif
            <div>
                @if($title)
                    <h2 data-preview-field="title" {!! \App\Support\AdminPreviewAttrs::html('about', 'title', 'Edit Heading') !!}>{{ $title }}</h2>
                @endif
                @if($copy)
                    <div class="cm-copy" data-preview-field="description" data-preview-html="1" {!! \App\Support\AdminPreviewAttrs::html('about', 'paragraph_1', 'Edit Introduction') !!}>{!! $copy !!}</div>
                @endif
                @if($points->isNotEmpty())
                    <ul class="cm-points">
                        @foreach($points as $point)
                            <li>
                                @if(filled($point['title'] ?? null))
                                    <strong>{{ $point['title'] }}</strong>
                                @endif
                                @if(filled($point['description'] ?? null))
                                    <span>{{ $point['description'] }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</section>
