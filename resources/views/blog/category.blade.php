@extends('layouts.inner')

@section('title', $category->name)
@section('page_title', $category->name)
@section('description', 'Posts in ' . $category->name)
@section('content')
    <div class="page-content">

        <section class="site-content blog-details">
            <div class="container">
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-9 blog-left-col">
                        <div class="row">
                            @if ($posts->count() > 0)
                                <div class="swiper-slider" data-autoplay="false" data-loop="false" data-columns="3"
                                    data-margin="30">
                                    <div class="swiper-wrapper">
                                        @foreach ($posts as $post)
                                            <article class="pbmit-blog-style-1 swiper-slide">
                                                <div class="post-item">
                                                    <div class="pbminfotech-box-content">
                                                        <div class="pbmit-featured-container">
                                                            <div class="pbmit-featured-img-wrapper">
                                                                <img src="{{ $post->main_image_url ?? asset('images/default.jpg') }}"
                                                                    alt="{{ $post->title ?? 'No Title' }}"
                                                                    class="img-fluid rounded"
                                                                    style="max-width: 250px; height: auto; object-fit: cover;">
                                                                <a class="pbmit-link"
                                                                    href="{{ route('blog.show', $post->slug) }}"></a>
                                                            </div>

                                                            <div class="pbmit-meta-date-wrapper">
                                                                <span class="pbmit-post-date">
                                                                    <span
                                                                        class="pbmit-date">{{ $post->created_at?->format('d') }}</span>
                                                                    <span
                                                                        class="pbmit-month">{{ $post->created_at?->format('M') }}</span>
                                                                </span>
                                                            </div>

                                                            <div class="pbmit-meta-wraper">
                                                                <div class="pbmit-meta-author pbmit-meta-line">
                                                                    <span>{{ $post->creator?->name ?? 'Admin' }}</span>
                                                                </div>
                                                                <div class="pbmit-meta-category-wrapper pbmit-meta-line">
                                                                    <span
                                                                        class="pbmit-meta-category">{{ $post->category?->name ?? '' }}</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="pbmit-content-wrapper">
                                                            <h3 class="pbmit-post-title">
                                                                <a
                                                                    href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                                                            </h3>
                                                            <div class="pbminfotech-box-desc">
                                                                {{ \Illuminate\Support\Str::limit($post->short_description ?? strip_tags($post->content), 10) }}&hellip;
                                                            </div>
                                                            <div class="pbmit-blog-btn">
                                                                <a class="pbmit-button-inner"
                                                                    href="{{ route('blog.show', $post->slug) }}">
                                                                    <span class="pbmit-button-text">Read More</span>
                                                                    <span class="pbmit-button-icon">
                                                                        <i class="pbmit-base-icon-right-arrow"></i>
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Sidebar -->
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
    </div>
    </section>
    </div>
@endsection
