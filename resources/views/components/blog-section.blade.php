@props([
    'title' => 'Articles & blog posts with useful information',
    'subtitle' => 'Fresh News',
    'posts' => [
        [
            'image' => 'assets/images/homepage-2/blog/blog-img-01.jpg',
            'title' => 'The Future of Technology in Urban Development',
            'slug' => 'future-technology-urban-development',
            'date' => '06 Feb',
            'date_month' => 'Feb',
            'author' => 'Alex joy',
            'category' => 'Logistics',
            'category_slug' => 'logistics',
            'comments_count' => 3,
            'excerpt' =>
                'When evaluating a single group or company, its dominant source of revenue is typically used...',
        ],
        [
            'image' => 'assets/images/homepage-2/blog/blog-img-02.jpg',
            'title' => 'U.S. fund managers trim bank stocks on profit worries',
            'slug' => 'us-fund-managers-trim-bank-stocks',
            'date' => '06 Feb',
            'date_month' => 'Feb',
            'author' => 'Alex joy',
            'category' => 'Engineering',
            'category_slug' => 'engineering',
            'comments_count' => 3,
            'excerpt' =>
                'When evaluating a single group or company, its dominant source of revenue is typically used...',
        ],
        [
            'image' => 'assets/images/homepage-2/blog/blog-img-03.jpg',
            'title' => 'Role of Architecture in Disaster Relief and Resilience',
            'slug' => 'architecture-disaster-relief-resilience',
            'date' => '06 Feb',
            'date_month' => 'Feb',
            'author' => 'Alex joy',
            'category' => 'Construction',
            'category_slug' => 'construction',
            'comments_count' => 3,
            'excerpt' =>
                'When evaluating a single group or company, its dominant source of revenue is typically used...',
        ],
        [
            'image' => 'assets/images/homepage-2/blog/blog-img-04.jpg',
            'title' => 'Importance of Quality and Testing in Modern Factories',
            'slug' => 'quality-testing-modern-factories',
            'date' => '06 Feb',
            'date_month' => 'Feb',
            'author' => 'Alex joy',
            'category' => 'Industrial',
            'category_slug' => 'industrial',
            'comments_count' => 3,
            'excerpt' =>
                'When evaluating a single group or company, its dominant source of revenue is typically used...',
        ],
        [
            'image' => 'assets/images/homepage-2/blog/blog-img-05.jpg',
            'title' => 'The Role of Energy Storage in the Transition to Renewables',
            'slug' => 'energy-storage-renewables-transition',
            'date' => '06 Feb',
            'date_month' => 'Feb',
            'author' => 'Alex joy',
            'category' => 'Chemical',
            'category_slug' => 'chemical',
            'comments_count' => 3,
            'excerpt' =>
                'When evaluating a single group or company, its dominant source of revenue is typically used...',
        ],
        [
            'image' => 'assets/images/homepage-2/blog/blog-img-06.jpg',
            'title' => 'Automation & Human-Robot Collab: The New Workforce',
            'slug' => 'automation-human-robot-collaboration',
            'date_day' => '06',
            'date_month' => 'Feb',
            'author' => 'Alex joy',
            'category' => 'Engineering',
            'category_slug' => 'engineering',
            'comments_count' => 3,
            'excerpt' =>
                'When evaluating a single group or company, its dominant source of revenue is typically used...',
        ],
    ],
])

@php
    use Illuminate\Support\Str;
@endphp

<!-- Blog start -->
<section class="section-md blog-section-two">
    <div class="container">
        <div class="pbmit-heading-subheading text-center">
            <h4 class="pbmit-subtitle">{{ $subtitle }}</h4>
            <h2 class="pbmit-title">{{ $title }}</h2>
        </div>
        <div class="swiper-slider" data-autoplay="false" data-loop="false" data-dots="false" data-arrows="false"
            data-columns="3" data-margin="30" data-effect="slide">
            <div class="swiper-wrapper">
                @foreach ($posts as $post)
                    @php
                        // Split the date into day and month if it exists
                        $dateParts = isset($post['date']) ? explode(' ', $post['date']) : ['01', 'Jan'];
                        $dateDay = $dateParts[0] ?? '01';
                        $dateMonth = $dateParts[1] ?? 'Jan';
                    @endphp
                    <!-- Slide -->
                    <article class="pbmit-blog-style-1 swiper-slide">
                        <div class="post-item">
                            <div class="pbminfotech-box-content">
                                <div class="pbmit-featured-container">
                                    <div class="pbmit-featured-container-inner">
                                        <div class="pbmit-featured-img-wrapper">
                                            <div class="pbmit-featured-wrapper">
                                                <img src="{{ asset($post['image']) }}" class="img-fluid"
                                                    alt="{{ $post['title'] }}">
                                            </div>
                                        </div>
                                        <a class="pbmit-link" href="#"></a>
                                    </div>
                                    <div class="pbmit-meta-date-wrapper pbmit-meta-line">
                                        <span class="pbmit-post-date">
                                            <span class="pbmit-date">{{ $dateDay }}</span>
                                            <span class="pbmit-month">{{ $dateMonth }}</span>
                                        </span>
                                    </div>
                                    <div class="pbmit-meta-wraper">
                                        <div class="pbmit-meta-author pbmit-meta-line">
                                            <span class="pbmit-post-author">{{ $post['author'] }}</span>
                                        </div>
                                        <div class="pbmit-meta-category-wrapper pbmit-meta-line">
                                            <span class="pbmit-meta-category">
                                                <a href="#" rel="category tag">{{ $post['category'] }}</a>
                                            </span>
                                        </div>
                                        <div class="pbmit-meta-comment-wrapper pbmit-meta-line">
                                            {{-- <span class="pbmit-meta-comments">{{ $post['comments_count'] }}<span class="pbmit-comment-text">Comment</span></span> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="pbmit-content-wrapper">
                                    <h3 class="pbmit-post-title">
                                        <a href="#">{{ $post['title'] }}</a>
                                    </h3>
                                    <div class="pbminfotech-box-desc">
                                        {{ Str::limit($post['excerpt'], 100) }}&hellip;
                                    </div>
                                    <div class="pbmit-blog-btn">
                                        <a class="pbmit-button-inner" href="#">
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
</section>
<!-- Blog End -->
