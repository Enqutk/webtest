@props([
    'projects' => collect(),
    'categories' => collect(),
    'showFilters' => false,
    'limit' => null,
    'showHeader' => true,
    'eyebrow' => 'Selected projects',
    'title' => 'Our projects',
    'description' => null,
    'ctaText' => 'View full portfolio',
    'ctaUrl' => null,
])

@php
    $items = $limit ? $projects->take($limit) : $projects;
    $targetCtaUrl = $ctaUrl ?: route('portfolio.index');
@endphp

<section class="hz-section hz-portfolio" id="portfolio">
    <div class="container">
        @if($showHeader)
            <div class="row justify-content-between align-items-end mb-4 g-3">
                <div class="col-lg-7">
                    <p class="hz-eyebrow" data-preview-field="eyebrow" {!! \App\Support\AdminPreviewAttrs::html('portfolio', 'eyebrow', 'Edit Eyebrow') !!}>{{ $eyebrow }}</p>
                    <h2 class="hz-title mb-0" data-preview-field="title" {!! \App\Support\AdminPreviewAttrs::html('portfolio', 'title', 'Edit Title') !!}>{{ $title }}</h2>
                    @if($description)
                        <p class="hz-lead text-muted mt-2 mb-0" data-preview-field="description" {!! \App\Support\AdminPreviewAttrs::html('portfolio', 'description', 'Edit Description') !!}>{{ $description }}</p>
                    @else
                        <p class="hz-lead text-muted mt-2 mb-0" data-preview-field="description" style="display:none"></p>
                    @endif
                </div>
                @if(!$showFilters)
                    <div class="col-lg-auto">
                        <a href="{{ $targetCtaUrl }}" class="btn-hz-outline" data-preview-field="cta_text" {!! \App\Support\AdminPreviewAttrs::html('portfolio', 'cta_text', 'Edit Button') !!}>{{ $ctaText }}</a>
                    </div>
                @endif
            </div>
        @endif

        @if($showFilters && $categories->isNotEmpty())
            <div class="hz-filters" data-portfolio-filter>
                <button type="button" class="hz-filter-btn active" data-filter="all">All</button>
                @foreach($categories as $category)
                    <button type="button" class="hz-filter-btn" data-filter="{{ \Illuminate\Support\Str::slug($category) }}">
                        {{ $category }}
                    </button>
                @endforeach
            </div>
        @endif

        <div class="row g-4">
            @forelse($items as $project)
                @php
                    $image = $project->getFirstMediaUrl('image') ?: null;
                @endphp
                <div class="col-md-6 col-lg-4 hz-portfolio-item" data-category="{{ \Illuminate\Support\Str::slug($project->category ?: 'general') }}">
                    <article class="hz-project-card">
                        <a href="{{ route('portfolio.show', $project) }}" class="hz-project-card-media">
                            @if($image)
                                <img src="{{ $image }}" alt="{{ $project->name }}">
                            @endif
                            @if($project->category)
                                <span class="hz-project-card-tag">{{ $project->category }}</span>
                            @endif
                        </a>
                        <div class="hz-project-card-body">
                            <h3>
                                <a href="{{ route('portfolio.show', $project) }}">{{ $project->name }}</a>
                            </h3>
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags((string) $project->description), 110) }}</p>
                            <a href="{{ route('portfolio.show', $project) }}" class="hz-link">
                                View project <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-muted mb-0">Portfolio projects will appear here once added as Entities (type: Project) in admin.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
