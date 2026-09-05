@php
    $creator = $data['homeSections']['creator'] ?? $data['theme']['creator'] ?? [];
    $adminPreview = request()->boolean('admin_preview');
    $showCreator = !empty($creator['is_visible']) || $adminPreview;
    $routeSlug = $data['routeSlug'] ?? request()->route('slug');
    $creatorUrl = $creator['url'] ?? null;
    if ($creatorUrl === '/' || $creatorUrl === '') {
        $creatorHref = url('/');
    } elseif ($routeSlug && is_string($creatorUrl) && str_starts_with($creatorUrl, '/') && !str_starts_with($creatorUrl, '/card/')) {
        $creatorHref = url("/card/{$routeSlug}" . $creatorUrl);
    } else {
        $creatorHref = $creatorUrl ?: ($data['brandHomeUrl'] ?? url('/'));
    }
    $creatorOff = $adminPreview && empty($creator['is_visible']);
@endphp

@if($showCreator)
    <aside
        id="creator"
        class="hz-creator-bar{{ $creatorOff ? ' is-creator-off' : '' }}"
        aria-label="Platform creator"
        {!! \App\Support\AdminPreviewAttrs::html('creator', 'label', 'Edit Creator Bar', false) !!}
    >
        <div class="container hz-creator-bar-inner">
            <p class="hz-creator-bar-copy mb-0">
                <span class="hz-creator-bar-label" data-preview-field="label" {!! \App\Support\AdminPreviewAttrs::html('creator', 'label', 'Edit Label') !!}>{{ $creator['label'] ?? 'Creator of this platform' }}</span>
                <span class="hz-creator-bar-name" data-preview-field="name" {!! \App\Support\AdminPreviewAttrs::html('creator', 'name', 'Edit Name') !!}>{{ $creator['name'] ?? 'Kimem Cards' }}</span>
                <span class="hz-creator-bar-line" data-preview-field="line" style="{{ empty($creator['line']) ? 'display:none' : '' }}" {!! \App\Support\AdminPreviewAttrs::html('creator', 'line', 'Edit Line') !!}>{{ $creator['line'] ?? '' }}</span>
            </p>
            <a class="hz-creator-bar-link" href="{{ $creatorHref }}" style="{{ empty($creator['cta_text']) ? 'display:none' : '' }}" {!! \App\Support\AdminPreviewAttrs::html('creator', 'cta_text', 'Edit Button') !!}><span data-preview-field="cta_text">{{ $creator['cta_text'] ?? '' }}</span> <i class="bi bi-arrow-up-right"></i></a>
        </div>
    </aside>
@endif
