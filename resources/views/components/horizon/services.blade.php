@props(['services' => collect()])

<section class="hz-section bg-surface border-top border-bottom border-hz" id="services">
    <div class="container">
        <div class="row justify-content-between align-items-end mb-4 g-3">
            <div class="col-lg-7">
                <div class="hz-eyebrow">What we do</div>
                <h2 class="hz-title mb-0">Services shaped around real infrastructure needs</h2>
            </div>
            <div class="col-lg-auto">
                <a href="{{ route('services.index') }}" class="btn-hz-outline">All services</a>
            </div>
        </div>

        <div class="row g-4">
            @forelse($services as $service)
                <div class="col-md-6 col-lg-4">
                    <article class="hz-card">
                        <div class="hz-card-media">
                            <img src="{{ $service->main_image_url ?: asset('assets/images/service/service-img-01.jpg') }}" alt="{{ $service->title }}">
                        </div>
                        <div class="hz-card-body">
                            <h3>{{ $service->title }}</h3>
                            <p>{{ $service->short_description }}</p>
                            <a href="{{ route('services.show', $service->slug) }}" class="hz-link">
                                Read more <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-muted mb-0">Services will appear here once published in the admin panel.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
