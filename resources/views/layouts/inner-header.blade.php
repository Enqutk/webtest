	<!-- Header Main Area -->
	<header class="site-header pbmit-header-style-1" id="masthead">
		<div class="pbmit-sticky-header pbmit-header-sticky-yes pbmit-bg-color-white pbmit-sticky-header-mobile-yes"></div>
		<div class="pbmit-header-overlay">
			<div class="pbmit-main-header-area pbmit-infostack-header pbmit-bg-color-blackish">
				<div class="pbmit-top-area">
					<div class="container-fluid">
						<div class="pbmit-logo-area-inner d-flex align-items-center justify-content-between">
							<div class="site-branding">
								<h1 class="site-title">
									<a href="index.html">
										<img class="pbmit-main-logo" src="assets/images/logo/logo-04.png" alt="Induyst">
										<img class="pbmit-sticky-logo" src="assets/images/logo/logo-02.png" alt="Induyst">
									</a>
								</h1>
							</div>
							<div class="pbmit-header-text-box">
								<span>We are creative and ready for challenges!
									<a href="contact-us.html">
										<span class="pbmit-text-btn">Join Now!</span>
										<i class=" pbmit-base-icon-right-arrow"> </i>
									</a>
								</span>
							</div>
							<div class="pbmit-header-info ml-auto d-flex align-items-center">
								<div class="pbmit-header-info-inner">
									<div class="pbmit-header-box pbmit-header-box-1">
										<a href="tel:(000)123456789">
											<span class="pbmit-header-box-icon">
												<i class="pbmit-induyst-icon pbmit-induyst-icon-telephone"></i>
											</span>
											<span class="pbmit-box-content">
												<span class="pbmit-header-box-title">Need to talk</span>
												<span class="pbmit-header-box-content">{{ $data['phone'][0] ?? '' }}</span>
											</span>
										</a>
									</div>
									<div class="pbmit-header-box pbmit-header-box-2">
										<a href="#">
											<span class="pbmit-header-box-icon">
												<i class="pbmit-induyst-icon pbmit-induyst-icon-location-1"></i>
											</span>
											<span class="pbmit-box-content">
												<span class="pbmit-header-box-title">Main Location</span>
												<span class="pbmit-header-box-content">{{$data['address']}}</span>
											</span>
										</a>
									</div>
									<div class="pbmit-header-box pbmit-header-box-3">
										<a href="mailto:{{$data['email'][0]}}">
											<span class="pbmit-header-box-icon">
												<i class="pbmit-induyst-icon pbmit-induyst-icon-mail"></i>
											</span>
											<span class="pbmit-box-content">
												<span class="pbmit-header-box-title">Email address</span>
												<span class="pbmit-header-box-content"><span class="__cf_email__" data-cfemail="6f0100421d0a1f03162f0a170e021f030a410c0002">{{$data['email'][0] ?? ''}}</span></span>
										</a>
									</div>
								</div>
							</div>
							<div class="pbmit-right-box d-flex align-items-center">
								<div class="pbmit-header-search-btn">
									<a href="#" title="Search">
										<i class="pbmit-base-icon-search-2"></i>
									</a>
								</div>
								<div class="pbmit-burger-menu-wrapper">
									<div class="pbmit-mobile-menu-bg"></div>
									<button id="menu-toggle" class="nav-menu-toggle">
										<i class="pbmit-base-icon-menu-1"></i>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="pbmit-main-header-area">
					<div class="container-fluid">
						<div class="pbmit-header-content d-flex align-items-center justify-content-between pbmit-bg-color-white">
							<div class="pbmit-menuarea d-flex align-items-center">
								<div class="site-navigation">
									<nav class="main-navigation pbmit-navbar main-menu navbar-expand-xl navbar-light" id="site-navigation">
										<div>
											<ul class="navigation clearfix" id="pbmit-top-menu">
												<li class="{{ request()->routeIs('home') ? 'active' : '' }}">
													<a href="{{ route('home') }}">Home</a>
												</li>
												<li class="{{ request()->routeIs('about') ? 'active' : '' }}">
													<a href="{{ route('about') }}">About Us</a>
												</li>
												<li class="{{ request()->routeIs('services.index') ? 'active' : '' }}">
													<a href="{{ route('services.index') }}">Service</a>
												</li>
												<li class="{{ request()->routeIs('contact') ? 'active' : '' }}">
													<a href="{{ route('contact') }}">Contact Us</a>
												</li>
											</ul>

										</div>
									</nav>
								</div>
							</div>
							<div class="pbmit-right-box d-flex align-items-center">
								<div class="pbmit-header-social">
									<x-social-media />
								</div>
								<div class="pbmit-header-button">
									<a href="{{ route('contact') }}" class="pbmit-btn">
										<span class="pbmit-button-content-wrapper">
											<span class="pbmit-button-icon">
												<i class="pbmit-induyst-icon pbmit-induyst-icon-next"></i>
											</span>
											<span class="pbmit-button-text">Get in Touch</span>
										</span>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- Header Main Area End Here -->