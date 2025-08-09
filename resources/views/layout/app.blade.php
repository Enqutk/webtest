<!doctype html>
<html class="no-js" lang="en">
	
<!-- Mirrored from induyst-demo.pbminfotech.com/html-demo/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 09 Aug 2025 05:30:58 GMT -->
<head>
		<meta charset="utf-8">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title>@yield('title') | Veritasafrika</title>
		<meta name="robots" content="noindex, follow">
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Favicon -->
		<link rel="shortcut icon" type="image/x-icon" href="images/fevicon.png">
		<!-- CSS
			============================================ -->
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		<!-- Fontawesome -->
		<link rel="stylesheet" href="assets/css/fontawesome.css">
		<!-- Pbmit Induyst Icon -->
		<link rel="stylesheet" href="assets/fonts/pbmit-induyst-icon/pbmit_induyst.css">
		<!-- Base Icons -->
		<link rel="stylesheet" href="assets/css/pbminfotech-base-icons.css">
		<!-- Themify Icons -->
		<link rel="stylesheet" href="assets/css/themify-icons.css">
		<!-- Slick -->
		<link rel="stylesheet" href="assets/css/swiper.min.css">
		<!-- Magnific -->
		<link rel="stylesheet" href="assets/css/magnific-popup.css">
		<!-- AOS -->
		<link rel="stylesheet" href="assets/css/aos.css">
		<!-- Shortcode CSS -->
		<link rel="stylesheet" href="assets/css/shortcode.css">
		<!-- Base CSS -->
		<link rel="stylesheet" href="assets/css/base.css">
		<!-- Style CSS -->
		<link rel="stylesheet" href="assets/css/style.css">
		<!-- Responsive CSS -->
		<link rel="stylesheet" href="assets/css/responsive.css">
	</head>

@section('body')
    <body data-sidebar="dark" data-layout-mode="light">
@show
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.header') <!-- Include your header -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content') <!-- This is where the content will be injected -->
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('layouts.footer') <!-- Include your footer -->
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->