@extends('layouts.inner')

@section('title', 'About Us')
@section('eyebrow', 'Who we are')
@section('page_title', 'About Veritas Afrika')
@section('description', 'A multi-disciplinary consultancy providing expert professional services in civil engineering and infrastructure development.')

@section('page')
    <x-horizon.about :about="$data['aboutFeatures']" :features="$data['heroFeatures']" />

    @if($data['aboutSection1'] || $data['aboutSection2'])
        <section class="hz-section bg-surface border-top border-bottom border-hz">
            <div class="container">
                <div class="row g-5">
                    @if($data['aboutSection1'])
                        <div class="col-lg-6">
                            <img src="{{ $data['aboutSection1']['image'] }}" alt="About Veritas Afrika" class="w-100 border border-hz mb-3">
                            <div class="hz-lead">{!! $data['aboutSection1']['description'] !!}</div>
                        </div>
                    @endif
                    @if($data['aboutSection2'])
                        <div class="col-lg-6">
                            <img src="{{ $data['aboutSection2']['image'] }}" alt="Our approach" class="w-100 border border-hz mb-3">
                            <div class="hz-lead">{!! $data['aboutSection2']['description'] !!}</div>
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
