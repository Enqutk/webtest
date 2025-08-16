@extends('layouts.inner')

@section('title', $post->title)
@section('page_title', $post->title)
@section('description', $post->short_description)
@section('content')
    <div class="page-content">


        <!-- Blog Single Details -->
        <section class="site-content blog-details">
            <div class="container">
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-9 blog-left-col">
                        <div class="row">
                            <div class="col-md-12">
                                <article>
                                    <div class="post blog-classic">

                                        <div class="pbmit-img-wrapper">
                                            <div class="pbmit-featured-img-wrapper">
                                                <div class="pbmit-featured-wrapper">
                                                    <img src="{{ $post->main_image_url }}" class="img-fluid"
                                                        alt="{{ $post->title }}">
                                                </div>
                                            </div>
                                            <span class="pbmit-meta pbmit-meta-date">
                                                <span class="pbmit-date">{{ $post->created_at->format('d') }}</span>
                                                <span class="pbmit-month">{{ $post->created_at->format('M') }}</span>
                                            </span>
                                        </div>

                                        <!-- Post Content -->
                                        <div class="pbmit-blog-classic-inner">
                                            <!-- Meta -->
                                            <div class="pbmit-blog-meta pbmit-blog-meta-top">
                                                <span class="pbmit-meta pbmit-meta-author">
                                                    by <a class="pbmit-author-link"
                                                        href="#">{{ $post->creator->name ?? 'Admin' }}</a>
                                                </span>
                                                <span class="pbmit-meta pbmit-meta-cat">
                                                    <a href="#">{{ $post->category->name ?? 'Uncategorized' }}</a>
                                                </span>

                                            </div>

                                            <!-- Title -->
                                            <h3 class="pbmit-post-title">
                                                <a href="#">{{ $post->title }}</a>
                                            </h3>

                                            <!-- Content -->
                                            <div class="pbmit-firstletter">

                                                {!! $post->content !!}

                                            </div>

                                            <!-- Gallery -->
                                            @if ($gallery->count() > 0)
                                                <h3 class="pbmit-custom-title mt-4">Gallery</h3>
                                                <div class="row">
                                                    @foreach ($gallery as $image)
                                                        <div class="col-md-6 mb-3">
                                                            <figure>
                                                                <img src="{{ $image->getUrl() }}"
                                                                    class="img-fluid w-100 rounded" alt="Gallery Image">
                                                            </figure>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif


                                        </div>
                                    </div>


                                </article>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 blog-right-col">
                        <aside class="sidebar">


                            <!-- Categories -->
                            <div class="widget widget-categories">
                                <h5 class="widget-title">Categories</h5>

                                @foreach ($categories as $category)
                                    <span class="pbmit-cat-li">
                                        <a href="{{ route('blog.category', $category->slug) }}">{{ $category->name }}</a>
                                    </span>
                                @endforeach

                            </div>

                            <!-- Recent Posts -->
                            <div class="widget widget-recent-posts">
                                <h5 class="widget-title">Recent Posts</h5>
                                <ul class="recent-post-list">
                                    @foreach ($recentPosts as $recent)
                                        <li class="d-flex align-items-center mb-3">
                                            <a href="{{ route('blog.show', $recent->slug) }}" class="me-2"
                                                style="width: 60px; display: block;">
                                                <img src="{{ $recent->main_image_url }}" alt="{{ $recent->title }}"
                                                    class="img-fluid rounded"
                                                    style="width: 60px; height: 60px; object-fit: cover;">
                                            </a>
                                            <div>
                                                <small class="text-muted">
                                                    <span
                                                        style="background: #2471a3; color: #f3f8fd; border-radius: 999px; padding: 2px 12px; display: inline-block; font-size: 12px;">
                                                        {{ $recent->created_at->format('d M, Y') }}
                                                    </span>
                                                </small>
                                                <a href="{{ route('blog.show', $recent->slug) }}"
                                                    class="d-block fw-bold">{{ $recent->title }}</a>

                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>


                        </aside>
                    </div>
                </div>
            </div>
        </section>
        <!-- Blog Single Details End -->

    </div>
@endsection
