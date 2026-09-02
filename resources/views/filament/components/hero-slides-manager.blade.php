@php
    $record = (isset($getRecord) && is_callable($getRecord))
        ? $getRecord()
        : ((isset($this) && method_exists($this, 'getRecord')) ? $this->getRecord() : \App\Models\Organization::first());
    $theme = (is_array($record?->theme)) ? $record->theme : \App\Models\Organization::defaultTheme();
    $hero = $theme['home_sections']['hero'] ?? \App\Models\Organization::defaultHomeSections()['hero'];

    $title = $hero['title'] ?? 'Building resilient infrastructure for lasting communities';
    $badge = $hero['badge'] ?? 'Infrastructure · Engineering · Impact';
    $subtitle = $hero['subtitle'] ?? 'Engineering Excellence';
    $desc = $hero['description'] ?? 'We design, engineer, and deliver high-impact water and infrastructure systems...';
    $btn1Text = $hero['cta_text'] ?? 'Explore Our Work';
    $btn1Url = $hero['cta_url'] ?? '/portfolio';
    $btn2Text = $hero['secondary_cta_text'] ?? 'Our Services';
    $btn2Url = $hero['secondary_cta_url'] ?? '/our-services';
    $isVisible = $hero['is_visible'] ?? true;

    $slides = $hero['slides'] ?? \App\Models\Organization::defaultHeroSlides();

    $globalShape = $theme['image_shape'] ?? 'rounded-xl';
    $heroShape = $hero['image_shape'] ?? 'inherit';
    $effectiveShape = ($heroShape === 'inherit' || empty($heroShape)) ? $globalShape : $heroShape;
    $heroRadiusCss = \App\Models\Organization::getImageRadiusCss($effectiveShape)['border-radius'];
@endphp

<style>
    .hz-hero-manager-wrap {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        width: 100%;
    }
    .hz-admin-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 1.25rem;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }
    .dark .hz-admin-card {
        background: #111827;
        border-color: #1f2937;
    }
    .hz-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        border-bottom: 1px solid #f3f4f6;
        padding-bottom: 0.85rem;
        margin-bottom: 1rem;
    }
    .dark .hz-card-header {
        border-bottom-color: #1f2937;
    }
    .hz-slide-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 0.75rem 1rem;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 0.625rem;
        margin-bottom: 0.625rem;
        transition: all 0.15s ease;
    }
    .dark .hz-slide-row {
        background: #1f2937;
        border-color: #374151;
    }
    .hz-slide-row:hover {
        border-color: #3b82f6;
    }
    .hz-slide-thumb-box {
        width: 72px;
        height: 72px;
        min-width: 72px;
        max-width: 72px;
        min-height: 72px;
        max-height: 72px;
        border-radius: {{ $heroRadiusCss }} !important;
        overflow: hidden;
        background: #e5e7eb;
        border: 1px solid #d1d5db;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .dark .hz-slide-thumb-box {
        background: #374151;
        border-color: #4b5563;
    }
    .hz-slide-thumb-img {
        width: 72px !important;
        height: 72px !important;
        max-width: 72px !important;
        max-height: 72px !important;
        border-radius: {{ $heroRadiusCss }} !important;
        object-fit: cover !important;
        display: block !important;
    }
    .hz-pill {
        display: inline-flex;
        align-items: center;
        padding: 0.15rem 0.5rem;
        font-size: 0.6875rem;
        font-weight: 600;
        border-radius: 9999px;
    }
</style>

<div class="hz-hero-manager-wrap">
    {{-- Organization Switcher Banner --}}
    <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem; background:#f8fafc; border:1px solid #e2e8f0; border-radius:0.75rem; padding:0.875rem 1.25rem;">
        <div style="display:flex; align-items:center; gap:0.75rem;">
            <div style="width:2.25rem; height:2.25rem; border-radius:0.5rem; background:#0284c7; color:#fff; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.875rem;">
                {{ substr($record?->title ?? 'O', 0, 2) }}
            </div>
            <div>
                <span style="font-size:0.6875rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:#64748b; display:block;">Editing Organization:</span>
                <strong style="font-size:1.05rem; color:#0f172a;">{{ $record?->title ?? 'Default Organization' }}</strong>
                <span style="font-size:0.75rem; color:#64748b; margin-left:0.5rem;">(Link: <a href="{{ route('card.home', ['slug' => $record?->slug ?? 'default']) }}" target="_blank" style="color:#0284c7; font-weight:600; text-decoration:underline;">/card/{{ $record?->slug }}</a>)</span>
            </div>
        </div>
        <div style="display:flex; align-items:center; gap:0.625rem;">
            <label style="font-size:0.75rem; font-weight:700; color:#475569;">Switch Organization:</label>
            <select onchange="window.location.href='/mgt/home-page-sections?org=' + this.value" style="font-size:0.8125rem; border-radius:0.5rem; border:1px solid #cbd5e1; padding:0.375rem 0.75rem; background:#fff; font-weight:600; cursor:pointer;">
                @foreach(\App\Models\Organization::all() as $o)
                    <option value="{{ $o->id }}" {{ $o->id === $record?->id ? 'selected' : '' }}>{{ $o->title }} ({{ $o->slug }})</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Card 1: Banner Global Settings --}}
    <div class="hz-admin-card">
        <div class="hz-card-header">
            <div>
                <h3 style="font-size: 0.95rem; font-weight: 600; margin: 0; color: inherit; display: flex; align-items: center; gap: 0.5rem;">
                    <span>🌟</span> Hero Banner Global Settings
                </h3>
                <p style="font-size: 0.75rem; color: #6b7280; margin: 0.2rem 0 0 0;">Top headline, category badge, supporting copy, photo shape, and action button links.</p>
            </div>
            <button
                type="button"
                wire:click="mountAction('configureHeroBanner')"
                style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.45rem 0.9rem; font-size: 0.75rem; font-weight: 600; color: #ffffff; background: #ea580c; border: none; border-radius: 0.5rem; cursor: pointer; transition: background 0.15s;"
                onmouseover="this.style.background='#c2410c'"
                onmouseout="this.style.background='#ea580c'"
            >
                <x-heroicon-m-pencil-square style="width: 1rem; height: 1rem;" />
                Configure Banner (Modal)
            </button>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 0.85rem; font-size: 0.8125rem;">
            <div style="padding: 0.75rem; background: rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.06); border-radius: 0.5rem;">
                <div style="font-size: 0.65rem; text-transform: uppercase; font-weight: 600; color: #9ca3af; letter-spacing: 0.05em; margin-bottom: 0.3rem;">Headline & Eyebrow</div>
                <div style="font-weight: 700; font-size: 0.9rem; margin-bottom: 0.3rem;">{{ $title }}</div>
                <div style="color: #6b7280; display: flex; align-items: center; gap: 0.4rem; font-size: 0.75rem; flex-wrap: wrap;">
                    <span class="hz-pill" style="background: rgba(234, 88, 12, 0.12); color: #c2410c;">{{ $badge }}</span>
                    <span>&bull;</span>
                    <span>{{ $subtitle }}</span>
                    <span>&bull;</span>
                    <span class="hz-pill" style="background: rgba(59, 130, 246, 0.12); color: #2563eb;">🖼️ Photo Shape: {{ ucfirst($effectiveShape) }}</span>
                </div>
            </div>

            <div style="padding: 0.75rem; background: rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.06); border-radius: 0.5rem;">
                <div style="font-size: 0.65rem; text-transform: uppercase; font-weight: 600; color: #9ca3af; letter-spacing: 0.05em; margin-bottom: 0.3rem;">Action Buttons</div>
                <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 0.3rem;">
                    <span style="display: inline-flex; align-items: center; gap: 0.25rem; padding: 0.3rem 0.6rem; background: rgba(0,0,0,0.05); border-radius: 0.375rem; font-size: 0.75rem; font-weight: 500;">
                        🔹 {{ $btn1Text }} <span style="opacity: 0.6; font-family: monospace; font-size: 0.7rem;">({{ $btn1Url }})</span>
                    </span>
                    <span style="display: inline-flex; align-items: center; gap: 0.25rem; padding: 0.3rem 0.6rem; background: rgba(0,0,0,0.05); border-radius: 0.375rem; font-size: 0.75rem; font-weight: 500;">
                        🔸 {{ $btn2Text }} <span style="opacity: 0.6; font-family: monospace; font-size: 0.7rem;">({{ $btn2Url }})</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Card 2: Carousel Slides Manager --}}
    <div class="hz-admin-card">
        <div class="hz-card-header">
            <div>
                <h3 style="font-size: 0.95rem; font-weight: 600; margin: 0; color: inherit; display: flex; align-items: center; gap: 0.5rem;">
                    <span>🖼️</span> Hero Carousel Slides
                </h3>
                <p style="font-size: 0.75rem; color: #6b7280; margin: 0.2rem 0 0 0;">Add, edit, or remove slides displayed in the homepage carousel slider.</p>
            </div>
            <button
                type="button"
                wire:click="mountAction('addHeroSlide')"
                style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.45rem 0.9rem; font-size: 0.75rem; font-weight: 600; color: #ffffff; background: #059669; border: none; border-radius: 0.5rem; cursor: pointer; transition: background 0.15s;"
                onmouseover="this.style.background='#047857'"
                onmouseout="this.style.background='#059669'"
            >
                <x-heroicon-m-plus-circle style="width: 1rem; height: 1rem;" />
                Add Hero Slide (Modal)
            </button>
        </div>

        @if(empty($slides))
            <div style="text-align: center; padding: 2rem; border: 1px dashed #d1d5db; border-radius: 0.75rem; color: #9ca3af; font-size: 0.875rem;">
                No slides configured. Click "Add Hero Slide (Modal)" to create your first slide.
            </div>
        @else
            <div>
                @foreach($slides as $index => $slide)
                    @php
                        $slideTitle = $slide['title'] ?? 'Slide #' . ($index + 1);
                        $slideSubtitle = $slide['subtitle'] ?? '';
                        $slideDesc = $slide['description'] ?? '';
                        $slideBtnText = $slide['text_link'] ?? 'Explore services';
                        $slideBtnLink = $slide['button_link'] ?? '/our-services';
                        $slideVisible = $slide['is_visible'] ?? true;

                        $rawImg = $slide['image'] ?? null;
                        if (is_array($rawImg)) {
                            $rawImg = array_values($rawImg)[0] ?? null;
                        }
                        $imgUrl = $rawImg ? (str_starts_with($rawImg, 'http') ? $rawImg : asset('storage/' . ltrim($rawImg, '/'))) : null;
                    @endphp

                    <div class="hz-slide-row">
                        <div style="display: flex; align-items: center; gap: 0.85rem; min-width: 0;">
                            {{-- Strict 72x72 Thumb Box --}}
                            <div class="hz-slide-thumb-box">
                                @if($imgUrl)
                                    <img src="{{ $imgUrl }}" alt="{{ $slideTitle }}" class="hz-slide-thumb-img">
                                @else
                                    <x-heroicon-o-photo style="width: 1.5rem; height: 1.5rem; color: #9ca3af;" />
                                @endif
                            </div>

                            <div style="min-width: 0; display: flex; flex-direction: column; gap: 0.25rem;">
                                <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                                    <span style="font-weight: 700; font-size: 0.875rem; color: inherit; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $slideTitle }}</span>
                                    @if($slideSubtitle)
                                        <span class="hz-pill" style="background: rgba(0,0,0,0.06); color: inherit;">{{ $slideSubtitle }}</span>
                                    @endif
                                    @if($slideVisible)
                                        <span class="hz-pill" style="background: rgba(16, 185, 129, 0.15); color: #059669;">Visible</span>
                                    @else
                                        <span class="hz-pill" style="background: rgba(156, 163, 175, 0.2); color: #6b7280;">Hidden</span>
                                    @endif
                                </div>

                                <div style="font-size: 0.75rem; color: #6b7280; display: flex; align-items: center; gap: 0.6rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    <span>Button: <strong>{{ $slideBtnText }}</strong> <span style="font-family: monospace; font-size: 0.7rem;">({{ $slideBtnLink }})</span></span>
                                    @if($slideDesc)
                                        <span>&bull;</span>
                                        <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 260px;">{{ $slideDesc }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; gap: 0.4rem; flex-shrink: 0;">
                            {{-- Toggle Visibility Button --}}
                            <button
                                type="button"
                                wire:click="toggleHeroSlideVisibility({{ $index }})"
                                title="{{ $slideVisible ? 'Hide slide' : 'Show slide' }}"
                                style="padding: 0.4rem; border: 1px solid #d1d5db; background: transparent; border-radius: 0.375rem; cursor: pointer;"
                            >
                                @if($slideVisible)
                                    <x-heroicon-m-eye style="width: 1rem; height: 1rem; color: #059669;" />
                                @else
                                    <x-heroicon-m-eye-slash style="width: 1rem; height: 1rem; color: #9ca3af;" />
                                @endif
                            </button>

                            {{-- Edit Modal Button --}}
                            <button
                                type="button"
                                wire:click="mountAction('editHeroSlide', { index: {{ $index }} })"
                                style="display: inline-flex; align-items: center; gap: 0.25rem; padding: 0.35rem 0.7rem; font-size: 0.75rem; font-weight: 600; color: #2563eb; background: rgba(37, 99, 235, 0.08); border: 1px solid rgba(37, 99, 235, 0.2); border-radius: 0.375rem; cursor: pointer;"
                            >
                                <x-heroicon-m-pencil-square style="width: 0.875rem; height: 0.875rem;" />
                                Edit (Modal)
                            </button>

                            {{-- Delete Button --}}
                            <button
                                type="button"
                                wire:click="mountAction('deleteHeroSlide', { index: {{ $index }} })"
                                title="Delete slide"
                                style="padding: 0.4rem; border: 1px solid rgba(220, 38, 38, 0.2); background: rgba(220, 38, 38, 0.06); border-radius: 0.375rem; cursor: pointer;"
                            >
                                <x-heroicon-m-trash style="width: 1rem; height: 1rem; color: #dc2626;" />
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
