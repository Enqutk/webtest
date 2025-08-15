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
		<!-- icon  -->
		 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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

    
    <!-- JAVASCRIPT -->
@stack('scripts') <!-- This will include any scripts pushed to the stack -->

    <script src="assets/js/jquery.min.js"></script>
	<!-- Popper JS -->
	<script src="assets/js/popper.min.js"></script>
	<!-- Bootstrap JS -->
	<script src="assets/js/bootstrap.min.js"></script>
	<!-- jquery Waypoints JS -->
	<script src="assets/js/jquery.waypoints.min.js"></script>
	<!-- jquery Appear JS -->
	<script src="assets/js/jquery.appear.js"></script>
	<!-- Numinate JS -->
	<script src="assets/js/numinate.min.js"></script>
	<!-- Slick JS -->
	<script src="assets/js/swiper.min.js"></script>
	<!-- Magnific JS -->
	<script src="assets/js/jquery.magnific-popup.min.js"></script>
	<!-- Circle Progress JS -->
	<script src="assets/js/circle-progress.js"></script>
	<!-- countdown JS -->
	<script src="assets/js/jquery.countdown.min.js"></script> 
	<!-- AOS -->
	<script src="assets/js/aos.js"></script>
	<!-- GSAP -->
	<script src='assets/js/gsap.js'></script>
	<!-- Scroll Trigger -->
	<script src='assets/js/ScrollTrigger.js'></script>
	<!-- Split Text -->
	<script src='assets/js/SplitText.js'></script>
	<!-- Theia Sticky Sidebar JS -->
	<script src='assets/js/theia-sticky-sidebar.js'></script>
	<!-- GSAP Animation -->
	<script src='assets/js/gsap-animation.js'></script>
	<!-- Scripts JS -->
	<script src="assets/js/scripts.js"></script>
    <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'96c4da9acca2f7f3',t:'MTc1NDcxNzM0Ny4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='../cdn-cgi/challenge-platform/h/b/scripts/jsd/8359bcf47b68/maind41d.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script><script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"96c4da9acca2f7f3","version":"2025.7.0","serverTiming":{"name":{"cfExtPri":true,"cfEdge":true,"cfOrigin":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"125856bf84ab44059737e93b01aa0fef","b":1}' crossorigin="anonymous"></script>


</script>