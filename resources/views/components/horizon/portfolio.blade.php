@props(['projects' => collect(), 'categories' => collect(), 'showFilters' => false, 'limit' => null])

@php
    $items = $limit ? $projects->take($limit) : $projects;
@endphp

<section class="hz-section" id="portfolio">
    <div class="container">
        <div class="row justify-content-between align-items-end mb-4 g-3">
            <div class="col-lg-7">
                <div class="hz-eyebrow">Selected work</div>
                <h2 class="hz-title mb-0">Projects that move communities forward</h2>
            </div>
            @if(!$showFilters)
                <div class="col-lg-auto">
                    <a href="{{ route('portfolio.index') }}" class="btn-hz-outline">View portfolio</a>
                </div>
            @endif
        </div>

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
                <div class="col-md-6 col-lg-4 hz-portfolio-item" data-category="{{ \Illuminate\Support\Str::slug($project->category ?: 'general') }}">
                    <article class="hz-card">
                        <div class="hz-card-media">
                            <img src="{{ $project->image_url }}" alt="{{ $project->name }}">
                        </div>
                        <div class="hz-card-body">
                            @if($project->category)
                                <div class="hz-eyebrow mb-2">{{ $project->category }}</div>
                            @endif
                            <h3>{{ $project->name }}</h3>
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
