@php
    use App\Models\Hero;
    $heroes = Hero::where('status', \App\Enums\StatusEnum::active)->orderBy('order')->get();
@endphp

<div class="pbmit-slider-area pbmit-slider-two">
    <div class="swiper-slider" data-autoplay="true" data-loop="true" data-dots="false" data-arrows="true" data-columns="1"
        data-margin="0" data-effect="fade">
        <div class="swiper-wrapper">
            @foreach ($heroes as $hero)
                @php
                    $imageUrl = $hero->getFirstMediaUrl('image');
                @endphp

                <div class="swiper-slide" id="hero-slide-{{ $hero->id }}">
                    <div class="pbmit-slider-item">
                        <div class="pbmit-slider-bg" style="background-image: url('{{ $imageUrl }}');"></div>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-8 col-1">
                                    <div class="pbmit-slider-content">
                                        <h5 class="pbmit-slider-subtitle transform-right-1 transform-delay-1">
                                            <span>{{ $hero->subtitle }}</span>
                                        </h5>
                                        <h2 class="pbmit-slider-title transform-left transform-delay-2">
                                            <span class="first">{{ $hero->title }}</span>
                                        </h2>
                                        <p class="pbmit-slider-desc"><span>{{ $hero->description }}</span></p>

                                        <div class="pbmit-button d-flex align-items-center">
                                            <div class="transform-bottom transform-delay-4">
                                                <a href="{{ $hero->button_link ?? '#' }}" class="pbmit-btn white">
                                                    <span class="pbmit-button-content-wrapper">
                                                        <span class="pbmit-button-icon">
                                                            <i class="pbmit-induyst-icon pbmit-induyst-icon-next"></i>
                                                        </span>
                                                        <span class="pbmit-button-text">Discover More</span>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="ms-4 transform-delay-5">
                                                <div class="second-btn">
                                                    <a class="pbmit-btn-style-text white" href="{{ $hero->text_link ?? '#' }}">
                                                        <span class="pbmit-button-text">Explore Our Services</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- pbmit-slider-content -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
