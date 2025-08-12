@props([
    'title' => 'Serving with expertise in industries as one of World\'s leading Corporation!',
    'videoUrl' => 'https://www.youtube.com/watch?v=x36EQP2og-k',
    'subtitle' => 'Working Process',
    'chartDescription' => 'Company market share in the domestic market',
    'industriesTitle' => 'Available To All Industries',
    'industriesDescription' => 'Our specialists offer manufacturing of complex machined precision parts, as well as turning and milling, to support a wide host of industries.',
    'industries' => ['Manufacturing', 'Pharmaceutical', 'Defense', 'Off-Road / Petroleum', 'Nuclear', 'Automotive'],
    'locationsTitle' => 'OUR LOCATIONS',
    'mapImage' => './assiet/images/homepage-2/map.png'
])

<section class="video-section-two pbmit-bg-color-blackish">
    <div class="container-fluid p-0">
        <div class="video-play-bg" style="background-image: url({{ asset('assets/images/bg/cta-02.png') }})">
            <div class="row align-items-center">
                <div class="col-md-6 left-col">
                    <div class="pbmit-custom-heading">
                        <h2 class="pbmit-title">{{ $title }}</h2>
                    </div>
                </div>
                <div class="col-md-6 right-col">
                    <div class="text-md-end mt-md-0 mt-4">
                        <a href="{{ $videoUrl }}" class="pbmit-video-play-btn pbmin-lightbox-video">
                            <svg aria-hidden="true" class="e-font-icon-svg e-fas-play" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                <path d="M424.4 214.7L72.4 6.6C43.8-10.3 0 6.1 0 47.9V464c0 37.5 40.7 60.1 72.4 41.3l352-208c31.4-18.5 31.5-64.1 0-82.6z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="video-bottom-area">
            <div class="row">
                <div class="col-md-12 col-xl-3">
                    <div class="pbmit-heading-subheading">
                        <h4 class="pbmit-subtitle">{{ $subtitle }}</h4>
                    </div>
                    <div class="chart-wrap">
                        <div id="chart"></div>
                        <p class="chart-sub-heading">{{ $chartDescription }}</p>
                    </div>
                </div>
                <div class="col-md-12 col-xl-9">
                    <div class="row">
                        <div class="col-md-12 col-xl-6">
                            <div class="content-box">
                                <div class="pbmit-heading-subheading">
                                    <h4 class="pbmit-subtitle">{{ $industriesTitle }}</h4>
                                    <div class="pbmit-heading-desc">{{ $industriesDescription }}</div>
                                </div>
                                <ul class="list-group">
                                    @foreach($industries as $industry)
                                    <li class="list-group-item">
                                        <span class="pbmit-icon-list-icon">
                                            <i class="pbmit-induyst-icon pbmit-induyst-icon-check"></i>						
                                        </span>
                                        <span class="pbmit-icon-list-text">{{ $industry }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-6">
                            <div class="pbmit-heading-subheading">
                                <h4 class="pbmit-subtitle">{{ $locationsTitle }}</h4>
                            </div>
                            <div class="map-img">
                                <img src="{{ $mapImage }}" class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
