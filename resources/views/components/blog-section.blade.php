@props([
    'title' => 'Latest News & Articles',
    'subtitle' => 'Stay Updated',
    'posts' => []
])

<section class="blog-section-two pbmit-bg-color-light">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-md-12 col-xl-5">
                <div class="pbmit-heading-subheading">
                    <h4 class="pbmit-subtitle">{{ $subtitle }}</h4>
                    <h2 class="pbmit-title">{{ $title }}</h2>
                </div>
            </div>
            <div class="col-md-12 col-xl-7">
                <div class="swiper-slider pbmit-column-one" data-autoplay="false" data-loop="true" data-dots="false" data-arrows="true" data-columns="2" data-margin="30" data-effect="slide">
                    <div class="swiper-wrapper">
                        @foreach($posts as $post)
                        <article class="pbmit-blog-style-1 swiper-slide">
                            <div class="post-item">
                                <div class="pbminfotech-box-content">
                                    <div class="pbmit-featured-container">
                                        <div class="pbmit-featured-container-inner">
                                            <div class="pbmit-featured-img-wrapper">
                                                <div class="pbmit-featured-wrapper">
                                                    <img src="{{ $post['image'] ?? '' }}" class="img-fluid" alt="{{ $post['title'] ?? '' }}">
                                                </div>
                                            </div>
                                            <a class="pbmit-link" href="{{ $post['url'] ?? '#' }}"></a>
                                        </div>
                                        <div class="pbmit-meta-date-wrapper pbmit-meta-line">
                                            <span class="pbmit-post-date">
                                                <span class="pbmit-date">{{ $post['date'] ?? '06' }}</span>
                                                <span class="pbmit-month">{{ $post['month'] ?? 'Feb' }}</span>
                                            </span>
                                        </div>
                                        <div class="pbmit-meta-wraper">
                                            <div class="pbmit-meta-author pbmit-meta-line">
                                                <span class="pbmit-post-author">{{ $post['author'] ?? 'Alex joy' }}</span>
                                            </div>
                                            <div class="pbmit-meta-category-wrapper pbmit-meta-line">
                                                <span class="pbmit-meta-category">
                                                    <a href="{{ $post['categoryUrl'] ?? '#' }}" rel="category tag">{{ $post['category'] ?? 'Chemical' }}</a>
                                                </span>
                                            </div>
                                            <div class="pbmit-meta-comment-wrapper pbmit-meta-line">
                                                <span class="pbmit-meta-comments">{{ $post['comments'] ?? '3' }}<span class="pbmit-comment-text">Comment</span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pbmit-content-wrapper">
                                        <h3 class="pbmit-post-title">
                                            <a href="{{ $post['url'] ?? '#' }}">{{ $post['title'] ?? 'Blog Post Title' }}</a>
                                        </h3>
                                        <div class="pbminfotech-box-desc">
                                            {{ $post['excerpt'] ?? 'When evaluating a single group or company, its dominant source of revenue is typically used&hellip;' }}
                                        </div>
                                        <div class="pbmit-blog-btn">
                                            <a class="pbmit-button-inner" href="{{ $post['url'] ?? '#' }}">
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
            </div>
        </div>
    </div>
</section>
