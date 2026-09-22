@props([
    'config' => [],
])

@php
    $cfg = is_array($config) ? $config : [];
    $frames = collect($cfg['frames'] ?? [])->filter(fn ($frame) => is_array($frame))->values();
    $points = collect($cfg['points'] ?? [])->filter(fn ($point) => filled($point['title'] ?? null) || filled($point['description'] ?? null));
    $background = \App\Models\Organization::themeFileUrl($cfg['background_image'] ?? null);
@endphp

<section class="cm-block cm-spotlight" id="spotlight" {!! \App\Support\AdminPreviewAttrs::html('spotlight', 'background_image', 'Edit section background', false) !!}>
    <x-horizon.fill-background
        :image="$background"
        :opacity="$cfg['background_opacity'] ?? 80"
        :shade="$cfg['background_shade'] ?? 40"
        :focus-x="$cfg['background_focus_x'] ?? 50"
        :focus-y="$cfg['background_focus_y'] ?? 50"
    />
    <div class="container cm-inner">
        <div class="cm-spotlight-grid">
            <div class="cm-collage">
                @forelse($frames as $index => $frame)
                    @php $src = \App\Models\Organization::themeFileUrl($frame['image'] ?? null); @endphp
                    <figure class="cm-collage-item {{ $index === 0 ? 'is-lead' : '' }}" {!! \App\Support\AdminPreviewAttrs::html('spotlight', 'frame_'.$index, 'Edit photo '.($index + 1), false) !!}>
                        @if($src)
                            <img src="{{ $src }}" alt="{{ $frame['alt'] ?? '' }}" data-preview-field="frame_{{ $index }}">
                        @else
                            <span class="cm-photo-empty">Photo {{ $index + 1 }}</span>
                        @endif
                        @if($index === 0 && (filled($cfg['overlay'] ?? null) || filled($cfg['overlay_sub'] ?? null)))
                            <figcaption>
                                @if(filled($cfg['overlay'] ?? null))
                                    <strong>{{ $cfg['overlay'] }}</strong>
                                @endif
                                @if(filled($cfg['overlay_sub'] ?? null))
                                    <em>{{ $cfg['overlay_sub'] }}</em>
                                @endif
                            </figcaption>
                        @endif
                    </figure>
                @empty
                    <figure class="cm-collage-item is-lead">
                        <span class="cm-photo-empty">Add spotlight photos</span>
                        @if(filled($cfg['overlay'] ?? null) || filled($cfg['overlay_sub'] ?? null))
                            <figcaption>
                                @if(filled($cfg['overlay'] ?? null))
                                    <strong>{{ $cfg['overlay'] }}</strong>
                                @endif
                                @if(filled($cfg['overlay_sub'] ?? null))
                                    <em>{{ $cfg['overlay_sub'] }}</em>
                                @endif
                            </figcaption>
                        @endif
                    </figure>
                @endforelse
            </div>
            <div class="cm-spotlight-copy">
                @if(filled($cfg['eyebrow'] ?? null))
                    <p class="cm-kicker">{{ $cfg['eyebrow'] }}</p>
                @endif
                @if(filled($cfg['title'] ?? null))
                    <h2>{{ $cfg['title'] }}</h2>
                @endif
                @if(filled($cfg['description'] ?? null))
                    <p class="cm-copy">{{ $cfg['description'] }}</p>
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
