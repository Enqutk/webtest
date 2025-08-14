<section class="section-xxl fade-section">
    <div class="container">
        <div class="d-md-flex justify-content-between">
            <div class="pbmit-heading-subheading">
                <h4 class="pbmit-subtitle">Our Services</h4>
                <h2 class="pbmit-title">Our Water Infrastructure <br class="d-inline"> Expertise</h2>
            </div>
            <div class="service-arrow d-inline-flex"></div>
        </div>

        <div class="swiper-slider" data-autoplay="true" data-loop="true" data-dots="false" data-arrows="true"
            data-arrows-class="service-arrow" data-columns="3" data-margin="30" data-effect="slide">
            <div class="swiper-wrapper">
                @foreach ($services as $service)
                    <!-- Slide {{ $loop->iteration }} -->
                    <article class="pbmit-service-style-1 swiper-slide">
                        <div class="pbminfotech-post-item">
                            <div class="pbmit-box-content-wrap">
                                <div class="pbmit-image-wrap">
                                    <div class="pbmit-featured-img-wrapper">
                                        <div class="pbmit-featured-wrapper">
                                            <img src="{{ $service->main_image_url }}" class="img-fluid"
                                                alt="{{ $service->title }}">
                                        </div>
                                    </div>
                                    <div class="pbmit-service-icon-wrapper">
                                        <div class="pbmit-service-icon">
                                            {!! $service->getFirstMedia('svg') ? file_get_contents($service->getFirstMediaPath('svg')) : '' !!}
                                        </div>
                                    </div>

                                </div>
                                <div class="pbmit-service-content-wrap">
                                    <h3 class="pbmit-service-title">
                                        {{ $service->title }}</a>
                                    </h3>
                                    <div class="pbmit-service-description">
                                        <p>{{ $service->short_description }}</p>
                                    </div>
                                    <div class="pbmit-service-btn-wrapper">
                                        <div class="pbmit-service-btn">
                                            <a class="pbmit-button-inner"
                                                href="{{ route('service.show', $service->slug) }}">
                                                <span class="pbmit-button-text">Read More</span>
                                                <i class="pbmit-base-icon-right-arrow"></i>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>

        <div class="pbmit-bottom-text text-center mt-5 pt-md-2">
            Latest solutions, and decades of experience. <a href="#"><u>Explore All Services</u></a>
        </div>
    </div>
</section>
<!-- Service end -->
