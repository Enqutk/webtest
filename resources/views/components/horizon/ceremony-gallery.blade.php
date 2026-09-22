@props([
    'config' => [],
])

@php
    $cfg = is_array($config) ? $config : [];
    $tiles = collect($cfg['tiles'] ?? [])->filter(fn ($tile) => is_array($tile))->values();
    $background = \App\Models\Organization::themeFileUrl($cfg['background_image'] ?? null);
@endphp

<section class="cm-block cm-gallery" id="gallery">
    <x-horizon.fill-background
        :image="$background"
        :opacity="$cfg['background_opacity'] ?? 80"
        :shade="$cfg['background_shade'] ?? 40"
        :focus-x="$cfg['background_focus_x'] ?? 50"
        :focus-y="$cfg['background_focus_y'] ?? 50"
    />
    <div class="container cm-inner">
        @if(filled($cfg['eyebrow'] ?? null))
            <p class="cm-kicker">{{ $cfg['eyebrow'] }}</p>
        @endif
        @if(filled($cfg['title'] ?? null))
            <h2>{{ $cfg['title'] }}</h2>
        @endif
        @if(filled($cfg['description'] ?? null))
            <p class="cm-copy">{{ $cfg['description'] }}</p>
        @endif

        <div class="cm-mosaic">
            @forelse($tiles as $index => $tile)
                @php
                    $src = \App\Models\Organization::themeFileUrl($tile['image'] ?? null);
                    $span = $tile['span'] ?? 'tile';
                    if (! in_array($span, ['feature', 'wide', 'tile'], true)) {
                        $span = 'tile';
                    }
                @endphp
                <figure class="cm-mosaic-item is-{{ $span }}" {!! \App\Support\AdminPreviewAttrs::html('gallery', 'tile_'.$index, 'Edit picture '.($index + 1), false) !!}>
                    @if($src)
                        <img src="{{ $src }}" alt="{{ $tile['title'] ?? '' }}" data-preview-field="tile_{{ $index }}">
                    @else
                        <span class="cm-photo-empty">Photo {{ $index + 1 }}</span>
                    @endif
                    @if(filled($tile['title'] ?? null) || filled($tile['subtitle'] ?? null))
                        <figcaption>
                            @if(filled($tile['title'] ?? null))
                                <strong>{{ $tile['title'] }}</strong>
                            @endif
                            @if(filled($tile['subtitle'] ?? null))
                                <em>{{ $tile['subtitle'] }}</em>
                            @endif
                        </figcaption>
                    @endif
                </figure>
            @empty
                <p class="cm-copy">Add pictures and choose how wide each one sits in the grid.</p>
            @endforelse
        </div>
    </div>
</section>
