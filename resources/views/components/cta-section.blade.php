<!-- About Us Start -->
<section class="about-us-section-two">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-md-6">
                <div class="about-us-two-leftbox pbmit-bg-color-global" style="border-radius: 16px; overflow: hidden; position: relative; min-height: 320px; display: flex; flex-direction: column; justify-content: center;">
                    <div style="position: absolute; right: 0; top: 0; bottom: 0; width: 50%; background: url('{{ $content['image'] ?? asset('assets/images/default-cta-image.png') }}') center/cover no-repeat; border-top-right-radius: 16px; border-bottom-right-radius: 16px;"></div>
                    <div class="pbmit-custom-heading" style="position: relative; z-index: 2; padding: 48px 32px; max-width: 60%;">
                        <h4 class="pbmit-title" style="font-size: 2rem; font-weight: 600; color: #222;">{{ $content['short_description'] ?? '' }}</h4>
                        <a href="contact-us.html" class="pbmit-btn white mt-4">
                            <span class="pbmit-button-content-wrapper">
                                <span class="pbmit-button-icon">
                                    <i class="pbmit-induyst-icon pbmit-induyst-icon-next"></i>
                                </span>
                                <span class="pbmit-button-text">Contact Us Today</span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="about-us-two-rightbox pbmit-bg-color-light" style="border-radius: 16px; overflow: hidden; min-height: 320px; display: flex; flex-direction: column; justify-content: center; position: relative;">
                    <div style="position: absolute; right: 0; top: 0; bottom: 0; width: 50%; background: url('{{ $content2['image'] ?? asset('assets/images/default-cta-image.png') }}') center/cover no-repeat; border-top-right-radius: 16px; border-bottom-right-radius: 16px;"></div>
                    <div class="pbmit-custom-heading" style="position: relative; z-index: 2; padding: 48px 32px; max-width: 60%;">
                        <h4 class="pbmit-title" style="font-size: 1.2rem; font-weight: 500; color: #222;">{{ $content2['short_description'] ?? '' }}</h4>
                        <div class="pbminfotech-ele-fid-style-4 mt-4">
                            <div class="pbmit-fld-contents">
                                <div class="pbmit-fld-wrap">
                                    <div class="pbmit-fid-inner">
                                        <span class="pbmit-fid-before"></span>
                                        <span class="pbmit-number-rotate numinate" data-appear-animation="animateDigits" data-from="0" data-to="100000" data-interval="25" data-before="" data-before-style="" data-after="K" data-after-style=""></span>
                                    </div>
                                    <div class="pbmit-heading-desc">Projects Completed</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <!-- About Us End -->