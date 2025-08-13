@extends('layouts.inner')

@section('title', 'Contact Us')
@section('page_title', 'Contact Us')
@section('description', 'Get in touch with Veritas Afrika for expert civil engineering and infrastructure development services.')

@section('content')
<!-- Contact Start --> 
<section class="section-lgt">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-xl-6">
                <div class="contact-info">
                    <div class="pbmit-heading-subheading">
                        <h4 class="pbmit-subtitle">Get In Touch</h4>
                        <h2 class="pbmit-title">Let's discuss your project requirements</h2>
                    </div>
                    <p>Ready to start your next project? Contact us today to discuss how we can help bring your vision to life with our expert engineering services.</p>
                    
                    <div class="contact-details mt-4">
                        <div class="contact-item d-flex align-items-center mb-3">
                            <div class="contact-icon me-3">
                                <i class="pbmit-induyst-icon pbmit-induyst-icon-location-1"></i>
                            </div>
                            <div class="contact-text">
                                <h5>Address</h5>
                                <p>Hia cinema, Juba, South Sudan</p>
                            </div>
                        </div>
                        
                        <div class="contact-item d-flex align-items-center mb-3">
                            <div class="contact-icon me-3">
                                <i class="pbmit-induyst-icon pbmit-induyst-icon-telephone"></i>
                            </div>
                            <div class="contact-text">
                                <h5>Phone</h5>
                                <p>+211 923 2 41 605</p>
                            </div>
                        </div>
                        
                        <div class="contact-item d-flex align-items-center mb-3">
                            <div class="contact-icon me-3">
                                <i class="pbmit-induyst-icon pbmit-induyst-icon-mail"></i>
                            </div>
                            <div class="contact-text">
                                <h5>Email</h5>
                                <p>info@veritasafrika.com</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12 col-xl-6">
                <div class="contact-form-wrapper">
                    <form class="contact-form" method="POST" action="">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control" name="name" placeholder="Your Name *" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <input type="email" class="form-control" name="email" placeholder="Your Email *" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mb-3">
                            <input type="text" class="form-control" name="subject" placeholder="Subject *" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <textarea class="form-control" name="message" rows="5" placeholder="Your Message *" required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="pbmit-btn">
                                <span class="pbmit-button-content-wrapper">
                                    <span class="pbmit-button-icon">
                                        <i class="pbmit-induyst-icon pbmit-induyst-icon-next"></i>
                                    </span>
                                    <span class="pbmit-button-text">Send Message</span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact End -->

<!-- Map Section Start -->
<section class="section-lg">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="map-wrapper">
                    <div class="map-container" style="height: 400px; background-color: #f5f5f5;">
                        <div class="d-flex align-items-center justify-content-center h-100">
                            <div class="text-center">
                                <i class="pbmit-induyst-icon pbmit-induyst-icon-location-1" style="font-size: 3rem; color: #ccc;"></i>
                                <h4 class="mt-3">Interactive Map</h4>
                                <p>Map integration can be added here</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Map Section End -->
@endsection
