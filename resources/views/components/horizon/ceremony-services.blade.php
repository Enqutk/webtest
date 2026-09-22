@props([
    'services' => collect(),
    'config' => [],
    'icons' => [],
])

@php
    $cfg = is_array($config) ? $config : [];
    $icons = is_array($icons) ? $icons : [];
    $items = $services instanceof \Illuminate\Support\Collection ? $services : collect($services);
    $routeSlug = $data['routeSlug'] ?? request()->route('slug');
    $defaultIcons = ['bi bi-stars', 'bi bi-geo-alt', 'bi bi-flower1', 'bi bi-camera', 'bi bi-heart', 'bi bi-gem'];
    $linkLabel = trim((string) ($cfg['card_link_text'] ?? 'Learn more'));
    $background = \App\Models\Organization::themeFileUrl($cfg['background_image'] ?? null);
    $serviceUrl = function ($service) use ($routeSlug) {
        $slug = $service->slug ?? null;
        if (! $slug) {
            return '#';
        }
        if ($routeSlug) {
            return route('card.services.show', ['slug' => $routeSlug, 'service_slug' => $slug]);
        }

        return route('services.show', $slug);
    };
@endphp

<section class="cm-block cm-services" id="services">
    <x-horizon.fill-background
        :image="$background"
        :opacity="$cfg['background_opacity'] ?? 80"
        :shade="$cfg['background_shade'] ?? 40"
        :focus-x="$cfg['background_focus_x'] ?? 50"
        :focus-y="$cfg['background_focus_y'] ?? 50"
    />
    <div class="container cm-inner">
        @if(filled($cfg['eyebrow'] ?? null))
            <p class="cm-kicker" data-preview-field="eyebrow" {!! \App\Support\AdminPreviewAttrs::html('services', 'eyebrow', 'Edit Eyebrow') !!}>{{ $cfg['eyebrow'] }}</p>
        @endif
        @if(filled($cfg['title'] ?? null))
            <h2 data-preview-field="title" {!! \App\Support\AdminPreviewAttrs::html('services', 'title', 'Edit Title') !!}>{{ $cfg['title'] }}</h2>
        @endif
        @if(filled($cfg['description'] ?? null))
            <p class="cm-copy" data-preview-field="description" {!! \App\Support\AdminPreviewAttrs::html('services', 'description', 'Edit Description') !!}>{{ $cfg['description'] }}</p>
        @endif

        <div class="cm-cards">
            @forelse($items as $index => $service)
                @php
                    $icon = $icons[$service->slug] ?? null;
                    if (! filled($icon)) {
                        $icon = $defaultIcons[$index % count($defaultIcons)];
                    }
                @endphp
                <article class="cm-card" {!! \App\Support\AdminPreviewAttrs::html('services', 'service_'.$service->id, 'Edit Service', false) !!}>
                    <i class="{{ $icon }}" aria-hidden="true"></i>
                    <h3>{{ $service->title }}</h3>
                    @if(filled($service->short_description))
                        <p>{{ $service->short_description }}</p>
                    @endif
                    @if($linkLabel !== '')
                        <a href="{{ $serviceUrl($service) }}">{{ $linkLabel }}</a>
                    @endif
                </article>
            @empty
                <p class="cm-copy">Add services and they will appear here as cards.</p>
            @endforelse
        </div>
    </div>
</section>
