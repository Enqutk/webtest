@extends('layouts.inner')

@section('title', $entity->name)
@section('eyebrow', $entity->category ?: 'Project')
@section('page_title', $entity->name)
@section('description', \Illuminate\Support\Str::limit(strip_tags((string) $entity->description), 160))

@section('page')
<section class="hz-section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-7">
                <img src="{{ $entity->image_url }}" alt="{{ $entity->name }}" class="w-100 border border-hz">
            </div>
            <div class="col-lg-5">
                @if($entity->category)
                    <div class="hz-eyebrow">{{ $entity->category }}</div>
                @endif
                <h2 class="hz-title">{{ $entity->name }}</h2>
                <div class="hz-lead mb-4">{!! nl2br(e($entity->description)) !!}</div>
                @if($entity->link)
                    <a href="{{ $entity->link }}" class="btn-hz" target="_blank" rel="noopener">
                        Visit link <i class="bi bi-box-arrow-up-right"></i>
                    </a>
                @endif
                <div class="mt-3">
                    <a href="{{ route('portfolio.index') }}" class="hz-link">
                        <i class="bi bi-arrow-left"></i> Back to portfolio
                    </a>
                </div>
            </div>
        </div>

        @if($related->isNotEmpty())
            <div class="mt-5 pt-4 border-top border-hz">
                <h3 class="h4 mb-4">More projects</h3>
                <div class="row g-4">
                    @foreach($related as $project)
                        <div class="col-md-4">
                            <article class="hz-card">
                                <div class="hz-card-media">
                                    <img src="{{ $project->image_url }}" alt="{{ $project->name }}">
                                </div>
                                <div class="hz-card-body">
                                    <h3 class="h5">{{ $project->name }}</h3>
                                    <a href="{{ route('portfolio.show', $project) }}" class="hz-link">View project</a>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
