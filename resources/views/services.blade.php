@extends('layouts.inner')

@section('title', 'Our Services')
@section('page_title', 'Our Services')
@section('description', 'Discover our comprehensive range of civil engineering and infrastructure development services at Veritas Afrika.')

@section('content')
<!-- Services Start --> 
<section class="section-lgt">
    <div class="container">
        <div class="pbmit-heading-subheading text-center mb-5">
            <h4 class="pbmit-subtitle">What We Do</h4>
            <h2 class="pbmit-title">Our Professional Services</h2>
        </div>
        
        <div class="row">
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="service-card">
                    <div class="service-icon mb-3">
                        <i class="pbmit-induyst-icon pbmit-induyst-icon-check" style="font-size: 3rem; color: #007bff;"></i>
                    </div>
                    <h3 class="service-title">Civil Engineering</h3>
                    <p>Comprehensive civil engineering solutions including structural design, construction management, and infrastructure development.</p>
                    <a href="#" class="service-link">Learn More <i class="pbmit-induyst-icon pbmit-induyst-icon-next"></i></a>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="service-card">
                    <div class="service-icon mb-3">
                        <i class="pbmit-induyst-icon pbmit-induyst-icon-next" style="font-size: 3rem; color: #007bff;"></i>
                    </div>
                    <h3 class="service-title">Water Infrastructure</h3>
                    <p>Specialized water and wastewater systems design, from bulk supply and purification to sanitation networks.</p>
                    <a href="#" class="service-link">Learn More <i class="pbmit-induyst-icon pbmit-induyst-icon-next"></i></a>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="service-card">
                    <div class="service-icon mb-3">
                        <i class="pbmit-induyst-icon pbmit-induyst-icon-location-1" style="font-size: 3rem; color: #007bff;"></i>
                    </div>
                    <h3 class="service-title">Project Management</h3>
                    <p>End-to-end project management services ensuring timely delivery and quality control throughout the project lifecycle.</p>
                    <a href="#" class="service-link">Learn More <i class="pbmit-induyst-icon pbmit-induyst-icon-next"></i></a>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="service-card">
                    <div class="service-icon mb-3">
                        <i class="pbmit-induyst-icon pbmit-induyst-icon-telephone" style="font-size: 3rem; color: #007bff;"></i>
                    </div>
                    <h3 class="service-title">Consulting</h3>
                    <p>Expert consulting services providing strategic guidance and technical expertise for complex engineering projects.</p>
                    <a href="#" class="service-link">Learn More <i class="pbmit-induyst-icon pbmit-induyst-icon-next"></i></a>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="service-card">
                    <div class="service-icon mb-3">
                        <i class="pbmit-induyst-icon pbmit-induyst-icon-mail" style="font-size: 3rem; color: #007bff;"></i>
                    </div>
                    <h3 class="service-title">Sustainability</h3>
                    <p>Sustainable engineering solutions that minimize environmental impact while maximizing efficiency and performance.</p>
                    <a href="#" class="service-link">Learn More <i class="pbmit-induyst-icon pbmit-induyst-icon-next"></i></a>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="service-card">
                    <div class="service-icon mb-3">
                        <i class="pbmit-induyst-icon pbmit-induyst-icon-check" style="font-size: 3rem; color: #007bff;"></i>
                    </div>
                    <h3 class="service-title">Quality Assurance</h3>
                    <p>Rigorous quality control and testing procedures to ensure all projects meet the highest industry standards.</p>
                    <a href="#" class="service-link">Learn More <i class="pbmit-induyst-icon pbmit-induyst-icon-next"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Services End -->

<!-- Why Choose Us Start -->
<section class="section-lg pbmit-bg-color-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="why-choose-content">
                    <div class="pbmit-heading-subheading">
                        <h4 class="pbmit-subtitle">Why Choose Us</h4>
                        <h2 class="pbmit-title">Excellence in Every Project</h2>
                    </div>
                    <p>At Veritas Afrika, we combine technical expertise with innovative solutions to deliver exceptional results. Our commitment to quality, sustainability, and client satisfaction sets us apart in the industry.</p>
                    
                    <div class="features-list mt-4">
                        <div class="feature-item d-flex align-items-center mb-3">
                            <i class="pbmit-induyst-icon pbmit-induyst-icon-check me-3" style="color: #28a745;"></i>
                            <span>Experienced team of professionals</span>
                        </div>
                        <div class="feature-item d-flex align-items-center mb-3">
                            <i class="pbmit-induyst-icon pbmit-induyst-icon-check me-3" style="color: #28a745;"></i>
                            <span>Innovative and sustainable solutions</span>
                        </div>
                        <div class="feature-item d-flex align-items-center mb-3">
                            <i class="pbmit-induyst-icon pbmit-induyst-icon-check me-3" style="color: #28a745;"></i>
                            <span>Timely project delivery</span>
                        </div>
                        <div class="feature-item d-flex align-items-center mb-3">
                            <i class="pbmit-induyst-icon pbmit-induyst-icon-check me-3" style="color: #28a745;"></i>
                            <span>Competitive pricing</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="why-choose-image">
                    <img src="assets/images/service/service-img-01.jpg" alt="Engineering Services" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Why Choose Us End -->
@endsection
