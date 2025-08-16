@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <h1>{{ $post->title }}</h1>
        <p class="text-muted">
            By {{ $post->creator->name ?? 'Admin' }} |
            {{ $post->created_at->format('F d, Y') }} |
            Category: {{ $post->category->name ?? '' }}
        </p>

        <img src="{{ $post->main_image_url }}" alt="{{ $post->title }}" class="img-fluid mb-4">

        <div class="content mb-5">
            {!! $post->content !!}
        </div>

        @if ($gallery->count() > 0)
            <h3>Gallery</h3>
            <div class="row">
                @foreach ($gallery as $image)
                    <div class="col-md-3 mb-3">
                        <a href="{{ $image->getUrl() }}" target="_blank">
                            <img src="{{ $post->gallery_image_url }}" class="img-fluid rounded" alt="Gallery Image">
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
