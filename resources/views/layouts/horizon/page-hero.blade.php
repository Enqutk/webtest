@php
    $adminPreview = request()->boolean('admin_preview');
    $pageHeroEditUrl = null;

    if ($adminPreview) {
        $routeName = request()->route()?->getName();
        $pageMap = [
            'card.about' => route('admin.site-pages.edit', 'about') . '#page-header',
            'card.contact' => route('admin.site-pages.edit', 'contact') . '#page-header',
            'card.services.index' => route('admin.services.index') . '#page-header',
            'card.portfolio.index' => route('admin.portfolio.index') . '#page-header',
        ];
        $pageHeroEditUrl = $pageMap[$routeName] ?? null;
    }
@endphp

<section class="hz-page-hero" id="page-hero"
    @if($adminPreview && $pageHeroEditUrl)
        data-admin-section="page-hero"
        data-admin-label="Edit Page Header"
        data-admin-edit-url="{{ $pageHeroEditUrl }}"
    @endif>
    <div class="container">
        <div class="eyebrow" @if($adminPreview) data-preview-field="eyebrow" @endif>@yield('eyebrow', $data['siteName'] ?? config('app.name'))</div>
        <h1 @if($adminPreview) data-preview-field="title" @endif>@yield('page_title')</h1>
        @hasSection('description')
            <p @if($adminPreview) data-preview-field="description" @endif>@yield('description')</p>
        @endif
    </div>
</section>
