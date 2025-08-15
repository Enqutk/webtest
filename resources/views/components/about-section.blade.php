@props([
    'subtitle' => 'Why Choose us',
    'title' => 'We work for you since 1980 Industrial around the world.',
    'description' => 'Induyst is a full-service manufacturing company with 15 years of experience serving industries such as automotive, Our mission is to deliver products that meet the highest standards of quality and performance.',
    'features' => [],
    'buttonText' => 'Discover More',
    'buttonUrl' => 'about-us.html'
])

<section class="section-lg">
    <div class="container">
        <div class="row">
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
                                            <span class="pbmit-icon-list-text">{{ $feature }}</span>
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
                                        @foreach(['Our Vision', 'Our Solutions', 'Our Question'] as $index => $slideTitle)
                                        <article class="pbmit-miconheading-style-5 swiper-slide">
                                            <div class="pbmit-ihbox-style-5">
                                                <div class="pbmit-ihbox-box">
                                                    <div class="pbmit-ihbox-icon">
                                                        <div class="pbmit-ihbox-icon-wrapper pbmit-icon-type-icon">
                                                            <svg enable-background="new 0 0 55 55" viewBox="0 0 55 55" xmlns="http://www.w3.org/2000/svg">
                                                                <g>
                                                                    <path d="m29.1335468 10.5195313c-8.7938538-.9580631-15.9299316 5.9284649-15.9299316 14.2200317 0 4.25 1.869873 8.2600098 5.1398926 10.9899902 2.0400391 1.6900024 3.2800293 4.0200195 3.4899902 6.4799805-.9099121.0900269-1.6199951.8699951-1.6199951 1.8000488v2.4599609c0 1 .8199463 1.8200073 1.8199463 1.8200073h.880127l.8898926 1.75c.4699707.9000244 1.3900146 1.460022 2.4000244 1.460022h2.5899658c1.0200195 0 1.9400635-.5599976 2.4000244-1.460022l.9000225-1.75h.8699951c1 0 1.8199463-.8200073 1.8199463-1.8200073v-2.4599609c0-.9300537-.6999512-1.7000122-1.5998535-1.8000488.2099609-2.4599609 1.4399414-4.7799683 3.4699707-6.4699707 3.8199463-3.1900024 5.6899414-8.0400391 5.0200195-13-.8701172-6.3699951-6.1501465-11.5100098-12.5400372-12.2200317zm.7199707 38.830017c-.1999512.4000244-.6099854.6500244-1.0600586.6500244h-2.5899658c-.4499512 0-.8599854-.25-1.0599365-.6500244l-.5500488-1.0599976h5.8100586zm5.8399639-14.7700195c-2.3699951 1.9800415-3.7999249 4.7200317-4.0198956 7.6100464h-8.3400878c-.2099609-2.9000244-1.6499023-5.6400146-4.0200195-7.6199951-2.9299316-2.4400024-4.6098633-6.0200195-4.6098633-9.8300171 0-7.4488621 6.4384766-13.6078138 14.2598877-12.7200317 5.7200909.6300049 10.4400616 5.2200317 11.2200909 10.9200439.6098632 4.4400024-1.0700684 8.789978-4.4901124 11.6399536z"/>
                                                                    <path d="m27.5035419 16.9095459c-4.3399658 0-7.8599854 3.5200195-7.8599854 7.8599854 0 4.3400269 3.5200195 7.8600464 7.8599854 7.8600464s7.8499737-3.5200195 7.8499737-7.8600464c0-4.3399659-3.5100078-7.8599854-7.8499737-7.8599854zm3.0499268 6.5700073-3.6398926 3.6400146c-.275486.2948036-.7858067.2937374-1.0600586 0l-1.4100342-1.4100342c-.289917-.289978-.289917-.7699585 0-1.0599976.2900391-.289978.7700195-.289978 1.0600586 0l.8800049.8800049 3.1099854-3.1099854c.289917-.289978.7698975-.289978 1.0599365 0 .3000488.2899782.3000488.7700197 0 1.0599977z"/>
                                                                    <path d="m27.5000019 7.4515991c.4140625 0 .75-.3359375.75-.75v-2.4511719c0-.4140625-.3359375-.75-.75-.75s-.75.3359375-.75.75v2.4511719c0 .4140625.3359375.75.75.75z"/>
                                                                    <path d="m16.2714863 10.593689c.2445164.3354998.713129.4087811 1.0478516.1660156.3349609-.2436523.4091797-.7124023.1660156-1.0478516l-1.440918-1.9833984c-.2436523-.3334961-.7114258-.4086914-1.0478516-.1660156-.3349609.2436523-.4091797.7124023-.1660156 1.0478516z"/>
                                                                    <path d="m10.5459003 18.4745483-2.331543-.7573242c-.3945313-.1274414-.8173828.0878906-.9453125.4814453-.1279297.394043.0878906.8173828.4814453.9453125 2.4485273.7817211 2.3529682.7939453 2.5634766.7939453.850441 0 1.0403567-1.200592.2319336-1.4633789z"/>
                                                                    <path d="m10.0820332 29.6430054-2.331543.7573242c-.8078146.2625904-.6189566 1.4633789.2319336 1.4633789.2201662 0 .1981926-.0388012 2.5634766-.7939453.3935547-.1279297.609375-.5512695.4814453-.9453125-.128418-.3935547-.5493164-.6088867-.9453125-.4814453z"/>
                                                                    <path d="m47.2490234 30.4003296-2.3320313-.7573242c-.3916016-.1259766-.8168945.0878906-.9448242.4819336-.1279297.3935547.0878906.8168945.4819336.9448242l2.3320313.7573242c.3898964.1266537.8157921-.0844307.9448242-.4819336.1279297-.3935547-.0878906-.8168945-.4819336-.9448242z"/>
                                                                    <path d="m44.9169922 19.9013062 2.3320313-.7573242c.394043-.1279297.6098633-.5512695.4819336-.9448242-.128418-.3945313-.5527344-.6108398-.9448242-.4819336l-2.3320313.7573242c-.394043.1279297-.6098633.5512695-.4819336.9448242.1290779.3976268.5550575.6085472.9448242.4819336z"/>
                                                                    <path d="m38.7280273 10.593689 1.4414063-1.9833984c.2431641-.3349609.1689453-.8041992-.1660156-1.0478516-.3364258-.2441406-.8041992-.1699219-1.0478516.1660156l-1.4414062 1.9833984c-.2431641.3349609-.1689453.8041992.1660156 1.0478516.334629.2426977.8038101.1696463 1.0478515-.1660156z"/>
                                                                </g>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="pbmit-ihbox-contents">
                                                        <h2 class="pbmit-element-title">
                                                            {{ $slideTitle }}
                                                        </h2>
                                                        <div class="pbmit-heading-desc">
                                                            @if($index === 0)
                                                                Building long-term partnerships through responsiveness and reliability.
                                                            @elseif($index === 1)
                                                                Extensive, flexible services that tailored to address changing industry .
                                                            @else
                                                                What key challenges can we solve together to drive your business?
                                                            @endif
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
