@extends('layouts.inner')

@section('title', 'About Us')
@section('page_title', 'About Us')
@section('description', 'Learn about Veritas Afrika, a multi-disciplinary consultancy providing expert professional services in civil engineering and infrastructure development.')

@section('content')
    <!-- About Start -->
    <section class="section-lgt">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-xl-5 about-two-left-col">
                    <div class="about-two-img" style="background-image: url({{ asset('assets/images/homepage-2/about-img-01.png') }})"></div>
                </div>
                <div class="col-md-12 col-xl-7 about-two-right-col">
                    <div class="about-two-content">
                        <div class="pbmit-heading-subheading">
                            <h4 class="pbmit-subtitle">Why Choose us</h4>
                            <h2 class="pbmit-title">We work for you since 1980 Industrial around the world.</h2>
                        </div>
                        <div class="inner-box">
                            <div class="row">
                                <div class="col-md-7">
                                    <p>Veritas Afrika is a full-service consultancy company with extensive experience
                                        serving industries such as civil engineering, infrastructure development, and water
                                        management. Our mission is to deliver solutions that meet the highest standards of
                                        quality and performance.</p>
                                    <div class="list-group-wrap">
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <span class="pbmit-icon-list-icon">
                                                    <i class="pbmit-induyst-icon pbmit-induyst-icon-check"></i>
                                                </span>
                                                <span class="pbmit-icon-list-text">Reliable Guarantees You Can Trust</span>
                                            </li>
                                            <li class="list-group-item">
                                                <span class="pbmit-icon-list-icon">
                                                    <i class="pbmit-induyst-icon pbmit-induyst-icon-check"></i>
                                                </span>
                                                <span class="pbmit-icon-list-text">Commitment to Eco-Friendly
                                                    Materials</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <a href="{{ route('contact') }}" class="pbmit-btn blackish">
                                        <span class="pbmit-button-content-wrapper">
                                            <span class="pbmit-button-icon">
                                                <i class="pbmit-induyst-icon pbmit-induyst-icon-next"></i>
                                            </span>
                                            <span class="pbmit-button-text">Discover More</span>
                                        </span>
                                    </a>
                                </div>
                                <div class="col-md-5">
                                    <div class="swiper-slider pbmit-column-one mt-md-0 mt-5" data-autoplay="false"
                                        data-loop="true" data-dots="false" data-arrows="true" data-columns="1"
                                        data-margin="30" data-effect="slide">
                                        <div class="swiper-wrapper">
                                            <!-- Slide1 -->
                                            <article class="pbmit-miconheading-style-5 swiper-slide">
                                                <div class="pbmit-ihbox-style-5">
                                                    <div class="pbmit-ihbox-box">
                                                        <div class="pbmit-ihbox-icon">
                                                            <div class="pbmit-ihbox-icon-wrapper pbmit-icon-type-icon">
                                                                <i class="pbmit-induyst-icon pbmit-induyst-icon-check"></i>
                                                            </div>
                                                        </div>
                                                        <div class="pbmit-ihbox-contents">
                                                            <h2 class="pbmit-element-title">Our Vision</h2>
                                                            <div class="pbmit-heading-desc">Building long-term partnerships
                                                                through responsiveness and reliability.</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                            <!-- Slide2 -->
                                            <article class="pbmit-miconheading-style-5 swiper-slide">
                                                <div class="pbmit-ihbox-style-5">
                                                    <div class="pbmit-ihbox-box">
                                                        <div class="pbmit-ihbox-icon">
                                                            <div class="pbmit-ihbox-icon-wrapper pbmit-icon-type-icon">
                                                                <i class="pbmit-induyst-icon pbmit-induyst-icon-next"></i>
                                                            </div>
                                                        </div>
                                                        <div class="pbmit-ihbox-contents">
                                                            <h2 class="pbmit-element-title">Our Solutions</h2>
                                                            <div class="pbmit-heading-desc">Extensive, flexible services
                                                                tailored to address changing industry needs.</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
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
    <!-- About End -->

    <!-- Fid Start -->
    <section class="section-lg fade-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-xl-4 pbmit-fid-style-2-progress-top">
                    <div class="pbminfotech-ele-fid pbminfotech-ele-fid-style-2">
                        <div class="pbmit-fld-contents">
                            <div class="pbmit-fld-wrap">
                                <div class="pbmit-fid-inner">
                                    <span class="pbmit-fid-before"></span>
                                    <span class="pbmit-number-rotate numinate" data-appear-animation="animateDigits"
                                        data-from="0" data-to="92" data-interval="5" data-before="" data-before-style=""
                                        data-after="" data-after-style="">92</span>
                                    <span class="pbmit-fid"><span>%</span></span>
                                </div>
                                <h2 class="pbmit-fid-title"></h2>
                                <div class="pbmit-heading-desc">Projects completed successfully on time and budget</div>
                            </div>
                        </div>
                        <div class="pbmit-progressbar">
                            <div class="pbmit-progress-wrapper">
                                <div class="pbmit-progress-bar" data-max="92">1</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4 mt-md-0 mt-4 pbmit-fid-style-2-progress-top">
                    <div class="pbminfotech-ele-fid pbminfotech-ele-fid-style-2">
                        <div class="pbmit-fld-contents">
                            <div class="pbmit-fld-wrap">
                                <div class="pbmit-fid-inner">
                                    <span class="pbmit-fid-before"></span>
                                    <span class="pbmit-number-rotate numinate" data-appear-animation="animateDigits"
                                        data-from="0" data-to="85" data-interval="5" data-before="" data-before-style=""
                                        data-after="" data-after-style="">85</span>
                                    <span class="pbmit-fid"><span>%</span></span>
                                </div>
                                <h2 class="pbmit-fid-title"></h2>
                                <div class="pbmit-heading-desc">Client satisfaction rate across all projects</div>
                            </div>
                        </div>
                        <div class="pbmit-progressbar">
                            <div class="pbmit-progress-wrapper">
                                <div class="pbmit-progress-bar" data-max="85">1</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4 mt-xl-0 mt-md-5 mt-4 pbmit-fid-style-2-progress-top">
                    <div class="pbminfotech-ele-fid pbminfotech-ele-fid-style-2">
                        <div class="pbmit-fld-contents">
                            <div class="pbmit-fld-wrap">
                                <div class="pbmit-fid-inner">
                                    <span class="pbmit-fid-before"></span>
                                    <span class="pbmit-number-rotate numinate" data-appear-animation="animateDigits"
                                        data-from="0" data-to="90" data-interval="5" data-before="" data-before-style=""
                                        data-after="" data-after-style="">90</span>
                                    <span class="pbmit-fid"><span>%</span></span>
                                </div>
                                <h2 class="pbmit-fid-title"></h2>
                                <div class="pbmit-heading-desc">Projects delivered with sustainable solutions</div>
                            </div>
                        </div>
                        <div class="pbmit-progressbar">
                            <div class="pbmit-progress-wrapper">
                                <div class="pbmit-progress-bar" data-max="90">1</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fid End -->

    <!-- About Us Start -->
    <section class="about-us-section-two">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-md-6">
                    <div class="about-us-two-leftbox pbmit-bg-color-global">
                        <div class="pbmit-custom-heading">
                            <h4 class="pbmit-title">Trusted By Additional Than 450,000 Upbeat Individuals From Others</h4>
                        </div>
                        <a href="{{ route('contact') }}" class="pbmit-btn white">
                            <span class="pbmit-button-content-wrapper">
                                <span class="pbmit-button-icon">
                                    <i class="pbmit-induyst-icon pbmit-induyst-icon-next"></i>
                                </span>
                                <span class="pbmit-button-text">Take a Tour</span>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="about-us-two-rightbox pbmit-bg-color-light">
                        <div class="pbmit-custom-heading">
                            <h4 class="pbmit-title">Growth in revenue year over year by businesses using Our Company to
                                unify their in-store and online sales.</h4>
                        </div>
                        <div class="pbminfotech-ele-fid-style-4">
                            <div class="pbmit-fld-contents">
                                <div class="pbmit-fld-wrap">
                                    <div class="pbmit-fid-inner">
                                        <span class="pbmit-fid-before"></span>
                                        <span class="pbmit-number-rotate numinate" data-appear-animation="animateDigits"
                                            data-from="0" data-to="350" data-interval="50" data-before=""
                                            data-before-style="" data-after="" data-after-style="">350</span>
                                        <span class="pbmit-fid"><span>M</span></span>
                                    </div>
                                    <div class="pbmit-heading-desc">our company value</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Us End -->
@endsection