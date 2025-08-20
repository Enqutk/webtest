<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title') | Veritasafrika</title>
    <meta name="robots" content="noindex, follow">
    <meta name="description" content="@yield('description', 'Veritas Afrika is a multi-disciplinary consultancy providing expert professional services in civil engineering and infrastructure development.')">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/fevicon.png">
    <!-- CSS
        ============================================ -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.css') }}">
    <!-- Pbmit Induyst Icon -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/pbmit-induyst-icon/pbmit_induyst.css') }}">
    <!-- Base Icons -->
    <link rel="stylesheet" href="{{ asset('assets/css/pbminfotech-base-icons.css') }}">
    <!-- Themify Icons -->
    <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
    <!-- Slick -->
    <link rel="stylesheet" href="{{ asset('assets/css/swiper.min.css') }}">
    <!-- Magnific -->
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <!-- AOS -->
    <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}">
    <!-- Shortcode CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/shortcode.css') }}">
    <!-- Base CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/base.css') }}">
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <!-- icon  -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
    <!-- Page Wrapper -->
    <div class="page-wrapper" id="page">

        <!-- Header Main Area -->
        @include('layouts.inner-header')
        <!-- Header Main Area End Here -->

        <!-- Title Bar -->
        <div class="pbmit-title-bar-wrapper">
            <div class="container">
                <div class="pbmit-title-bar-content">
                    <div class="pbmit-title-bar-content-inner">
                        <div class="pbmit-tbar">
                            <div class="pbmit-tbar-inner container">
                                <h1 class="pbmit-tbar-title">@yield('page_title')</h1>
                            </div>
                        </div>
                        <div class="pbmit-breadcrumb">
                            <div class="pbmit-breadcrumb-inner">
                                <span>
                                    <a title="" href="{{ route('home') }}" class="home"><span>Veritas
                                            Afrika</span></a>
                                </span>
                                <span class="sep"></span>
                                <span><span
                                        class="post-root post post-post current-item">@yield('page_title')</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Title Bar End-->

        <!-- Page Content -->
        <div class="page-content">
            @yield('content')
        </div>
        <!-- Page Content End -->

        <!-- footer -->
        @include('layouts.footer')
        <!-- footer End -->

        <!-- Search Box Start Here -->
        <div class="pbmit-header-search-form">
            <div class="pbmit-search-overlay"></div>
            <div class="pbmit-header-search-form-wrapper">
                <div class="pbmit-search-close">
                    <svg class="qodef-svg--close qodef-m" xmlns="http://www.w3.org/2000/svg" width="28.163"
                        height="28.163" viewBox="0 0 26.163 26.163">
                        <rect width="36" height="1" transform="translate(0.707) rotate(45)"></rect>
                        <rect width="36" height="1" transform="translate(0 25.456) rotate(-45)"></rect>
                    </svg>
                </div>
                <form role="search" method="get" class="search-form" action="#">
                    <input type="search" id="search-form" class="search-field" placeholder="Search …" value=""
                        name="s">
                    <button type="submit" class="search-submit " title="Search"></button>
                    <div class="pbmit-search-line"></div>
                </form>
            </div>
        </div>
        <!-- Search Box End Here -->

        <!-- Scroll To Top -->
        <div class="pbmit-backtotop">
            <div class="pbmit-arrow">
                <i class="pbmit-base-icon-up-open-big"></i>
            </div>
            <div class="pbmit-hover-arrow">
                <i class="pbmit-base-icon-up-open-big"></i>
            </div>
        </div>
        <!-- Scroll To Top

    </div>
    <!-- Page Wrapper End -->

        <!-- JS
        ============================================ -->
        <!-- jQuery JS -->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <!-- Popper JS -->
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <!-- Bootstrap JS -->
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <!-- jquery Waypoints JS -->
        <script src="{{ asset('assets/js/jquery.waypoints.min.js') }}"></script>
        <!-- jquery Appear JS -->
        <script src="{{ asset('assets/js/jquery.appear.js') }}"></script>
        <!-- Numinate JS -->
        <script src="{{ asset('assets/js/numinate.min.js') }}"></script>
        <!-- Slick JS -->
        <script src="{{ asset('assets/js/swiper.min.js') }}"></script>
        <!-- Magnific JS -->
        <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
        <!-- Circle Progress JS -->
        <script src="{{ asset('assets/js/circle-progress.js') }}"></script>
        <!-- countdown JS -->
        <script src="{{ asset('assets/js/jquery.countdown.min.js') }}"></script>
        <!-- AOS -->
        <script src="{{ asset('assets/js/aos.js') }}"></script>
        <!-- GSAP -->
        <script src="{{ asset('assets/js/gsap.js') }}"></script>
        <!-- Scroll Trigger -->
        <script src="{{ asset('assets/js/ScrollTrigger.js') }}"></script>
        <!-- Split Text -->
        <script src="{{ asset('assets/js/SplitText.js') }}"></script>
        <!-- Theia Sticky Sidebar JS -->
        <script src="{{ asset('assets/js/theia-sticky-sidebar.js') }}"></script>
        <!-- GSAP Animation -->
        <script src="{{ asset('assets/js/gsap-animation.js') }}"></script>
        <!-- Scripts JS -->
        <script src="{{ asset('assets/js/scripts.js') }}"></script>

        @stack('scripts')
</body>

</html>
