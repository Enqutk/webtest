<!-- Header Main Area -->
<header class="site-header pbmit-header-style-2" id="masthead">
    <div class="pbmit-sticky-header pbmit-header-sticky-yes pbmit-bg-color-white pbmit-sticky-header-mobile-yes">
    </div>
    <div class="pbmit-header-overlay">
        <div class="pbmit-main-header-area">
            <div class="pbmit-header-content-area">
                <div class="container-fluid">
                    <div
                        class="pbmit-header-content d-flex align-items-center justify-content-between pbmit-header-wrapper pbmit-bg-color-blackish">
                        <div class="pbmit-header-menu-area d-flex align-items-center">
                            <div class="pbmit-logo-area">
                                <div class="site-branding">
                                    <h1 class="site-title">
                                        <a href="index.html">
                                            <img class="pbmit-main-logo"
                                                src="{{ asset('assets/images/logo/logo-04.png') }}" alt="Induyst">
                                            <img class="pbmit-sticky-logo"
                                                src="{{ asset('assets/images/logo/logo-02.png') }}" alt="Induyst">
                                        </a>
                                    </h1>
                                </div>
                            </div>
                            <div class="pbmit-menuarea d-flex align-items-right">
                                <div class="site-navigation">
                                    <nav class="main-navigation pbmit-navbar main-menu navbar-expand-xl navbar-light"
                                        id="site-navigation">
                                        <div>
                                            <ul class="navigation clearfix" id="pbmit-top-menu">
                                                <li><a href="{{ route('home') }}">Home</a></li>
                                                <li><a href="{{ route('about') }}">About Us</a></li>
                                                <li><a href="{{ route('services.index') }}">Services</a></li>
                                                <li><a href="{{ route('contact') }}">Contact Us</a></li>
                                            </ul>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="pbmit-right-box d-flex align-items-center">
                        <div class="pbmit-header-button">
                                
                            </div>
                            <div class="pbmit-header-search-btn">
                               
                            </div>
                            <div class="pbmit-burger-menu-wrapper">
                             
                            </div>
                       </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-home-section />
</header>
<!-- Header Main Area End Here -->
