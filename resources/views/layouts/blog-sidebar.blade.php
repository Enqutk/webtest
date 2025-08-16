<aside class="sidebar">

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
                        <img src="{{ $recent->main_image_url }}" alt="{{ $recent->title }}" class="img-fluid rounded"
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
