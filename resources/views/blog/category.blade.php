@extends('layouts.inner')

@section('title', $category->name)
@section('page_title', $category->name)
@section('description', 'Posts in ' . $category->name)
@section('content')
    <div class="page-content">

        <section class="site-content blog-details">
            <div class="container">
                <div class="row">
                    <!-- Main Content -->
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
                                                                {{ $post->excerpt }}
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
                        @include('layouts.blog-sidebar')
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
