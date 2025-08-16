

<section class="section-lg">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xl-5 about-two-left-col">
                <div class="about-two-img" style="background-image: url('{{ $image }}');"></div>  
            </div>
            <div class="col-md-12 col-xl-7 about-two-right-col">
                <div class="about-two-content">
                    <div class="pbmit-heading-subheading">
                        <h4 class="pbmit-subtitle">{{ $subtitle }}</h4>
                        <h2 class="pbmit-title">{{ $title }}</h2>
                    </div>
                    <div class="inner-box">
                        <div class="row">
                            <div class="col-md-7">
                                <p>{{ $description }}</p>
                                @if(count($features) > 0)
                                <div class="list-group-wrap">
                                    <ul class="list-group">
                                        @foreach($features as $feature)
                                        <li class="list-group-item">
                                            <span class="pbmit-icon-list-icon">
                                                <i class="pbmit-induyst-icon pbmit-induyst-icon-check"></i>						
                                            </span>
                                            <span class="pbmit-icon-list-text">{{ is_array($feature) ? ($feature['title'] ?? '') : $feature }}</span>

                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <a href="{{ $buttonUrl }}" class="pbmit-btn blackish">
                                    <span class="pbmit-button-content-wrapper">
                                        <span class="pbmit-button-icon">
                                            <i class="pbmit-induyst-icon pbmit-induyst-icon-next"></i>
                                        </span>
                                        <span class="pbmit-button-text">{{ $buttonText }}</span>
                                    </span>
                                </a>
                            </div>
                            <div class="col-md-5">
                                <div class="swiper-slider pbmit-column-one mt-md-0 mt-5" data-autoplay="false" data-loop="true" data-dots="false" data-arrows="true" data-columns="1" data-margin="30" data-effect="slide">
                                    <div class="swiper-wrapper">
                                        @foreach($slidePages as $slide)
                                        <article class="pbmit-miconheading-style-5 swiper-slide">
                                            <div class="pbmit-ihbox-style-5">
                                                <div class="pbmit-ihbox-box">
                                                    <div class="pbmit-ihbox-icon">
                                                        <div class="pbmit-ihbox-icon-wrapper pbmit-icon-type-icon">
                                                            @if(!empty($slide['icon']))
                                                                <i class="{{ $slide['icon'] }}"></i>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="pbmit-ihbox-contents">
                                                        <h2 class="pbmit-element-title">
                                                            {{ $slide['title'] ?? '' }}
                                                        </h2>
                                                        <div class="pbmit-heading-desc">
                                                            {{ $slide['description'] ?? '' }}
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
                </div>
            </div>
        </div>
    </div>
</section>
