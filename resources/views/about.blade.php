@extends('layouts.inner')

@section('title', 'About Us')
@section('page_title', 'About Us')
@section('description', 'Learn about Veritas Afrika, a multi-disciplinary consultancy providing expert professional services in civil engineering and infrastructure development.')

@section('content')
    <!-- About Start -->

    @if($data['aboutFeatures'])
    <x-about-section
        :features="$data['aboutFeatures']?->metadata ?? []"
        :slidePages="$data['aboutFeatures']?->list_items ?? []"
        image="{{ $data['aboutFeatureImageUrl'] }}"
        subtitle="{{ $data['aboutFeatures']?->subtitle ?? '' }}"
        title="{{ $data['aboutFeatures']?->title ?? '' }}"
        description="{{ $data['aboutFeatures']?->short_description ?? '' }}"
        buttonText="Discover More"
        buttonUrl="#" />
    @endif

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

    <x-about-feature />
@endsection