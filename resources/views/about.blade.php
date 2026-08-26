@extends('layouts.inner')

@section('title', 'About Us')
@section('eyebrow', 'Who we are')
@section('page_title', 'About Veritas Afrika')
@section('description', 'A multi-disciplinary consultancy providing expert professional services in civil engineering and infrastructure development.')

@section('page')
    <x-horizon.about
        :about="$data['aboutFeatures']"
        :features="$data['heroFeatures']"
        :show-link="false"
    />

    @if($data['aboutSection1'] || $data['aboutSection2'])
        <section class="hz-section hz-about-story bg-surface border-top border-bottom border-hz">
            <div class="container">
                <div class="row justify-content-center mb-4">
                    <div class="col-lg-8 text-center">
                        <p class="hz-eyebrow">Our story</p>
                        <h2 class="hz-title">How we work</h2>
                    </div>
                </div>
                <div class="row g-4">
                    @if($data['aboutSection1'])
                        <div class="col-lg-6">
                            <article class="hz-about-panel">
                                <div class="hz-about-panel-media">
                                    <img
                                        src="{{ $data['aboutSection1']['image'] ?: asset('assets/images/homepage-2/about-img-01.png') }}"
                                        alt="Our practice"
                                    >
                                </div>
                                <div class="hz-about-panel-body">
                                    <h3 class="h4 mb-3">Our practice</h3>
                                    <div class="hz-lead mb-0">{!! $data['aboutSection1']['description'] !!}</div>
                                </div>
                            </article>
                        </div>
                    @endif
                    @if($data['aboutSection2'])
                        <div class="col-lg-6">
                            <article class="hz-about-panel">
                                <div class="hz-about-panel-media">
                                    <img
                                        src="{{ $data['aboutSection2']['image'] ?: asset('assets/images/banner-slider-img/slider3-04.jpg') }}"
                                        alt="Our approach"
                                    >
                                </div>
                                <div class="hz-about-panel-body">
                                    <h3 class="h4 mb-3">Our approach</h3>
                                    <div class="hz-lead mb-0">{!! $data['aboutSection2']['description'] !!}</div>
                                </div>
                            </article>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    <x-horizon.stats :stats="$data['stats']" />
    <x-horizon.team :team="$team" />
    <x-horizon.clients :clients="$clients" />
    <x-horizon.cta />
@endsection
