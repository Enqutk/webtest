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
						<div class="pbmit-main-header-area" style="max-width: 1000px; margin: 0 auto; margin-top: 60px;">
							<div class="container-fluid" style="max-width: 900px;">
								<div class="pbmit-header-content d-flex align-items-center justify-content-center pbmit-bg-color-white">
									<div class="pbmit-menuarea d-flex align-items-center justify-content-center" style="width: 100%;">
										<div class="site-navigation" style="width: 100%;">
											<nav class="main-navigation pbmit-navbar main-menu navbar-expand-xl navbar-light" id="site-navigation">
												<!-- Desktop Menu -->
												<ul class="navigation clearfix d-none d-xl-flex" id="pbmit-top-menu" style="justify-content: center; width: 100%;">
													<li class="{{ request()->routeIs('home') ? 'active' : '' }}">
														<a href="{{ route('home') }}">Home</a>
													</li>
													<li class="{{ request()->routeIs('about') ? 'active' : '' }}">
														<a href="{{ route('about') }}">About Us</a>
													</li>
													<li class="{{ request()->routeIs('services.index') ? 'active' : '' }}">
														<a href="{{ route('services.index') }}">Our Service</a>
													</li>
													<li class="{{ request()->routeIs('contact') ? 'active' : '' }}">
														<a href="{{ route('contact') }}">Contact Us</a>
													</li>
												</ul>
												<!-- Mobile Menu -->
												<ul class="navigation clearfix d-xl-none" id="pbmit-top-menu-mobile" style="flex-direction: column; align-items: center; width: 100%; background: #c8c8c8ab; position: absolute; top: 100%; left: 0; z-index: 999; display: none;">
													<li>
														<a href="{{ route('home') }}">Home</a>
													</li>
													<li>
														<a href="{{ route('about') }}">About</a>
													</li>
													<li>
														<a href="{{ route('services.index') }}">Service</a>
													</li>
													<li>
														<a href="{{ route('contact') }}">Contact</a>
													</li>
												</ul>
												<script>
													document.addEventListener('DOMContentLoaded', function() {
														const menuToggle = document.getElementById('menu-toggle');
														const mobileMenu = document.getElementById('pbmit-top-menu-mobile');
														if (menuToggle && mobileMenu) {
															menuToggle.addEventListener('click', function(e) {
																e.preventDefault();
																mobileMenu.style.display = mobileMenu.style.display === 'block' ? 'none' : 'block';
															});
														}
													});
												</script>
										</div>
										</nav>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</header>
	<!-- Header Main Area End Here -->