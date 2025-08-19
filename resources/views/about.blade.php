@extends('layouts.inner')

@section('title', 'About Us')
@section('page_title', 'About Us')
@section('description', 'Learn about Veritas Afrika, a multi-disciplinary consultancy providing expert professional services in civil engineering and infrastructure development.')

@section('content')
    <!-- About Start -->

    @if($data['aboutFeatures'])
    <x-about-section
        image="{{ $data['aboutFeatureImageUrl'] }}"
        subtitle="{{ $data['aboutFeatures']?->subtitle ?? '' }}"
        title="{{ $data['aboutFeatures']?->title ?? '' }}"
        description="{{ $data['aboutFeatures']?->short_description ?? '' }}"
        />
    @endif

    <!-- About End -->




    <x-about-feature
        image1="{{ $data['aboutSection1']['image'] }}"
        description1="{{ $data['aboutSection1']['description'] }}"
        image2="{{ $data['aboutSection2']['image'] }}"
        description2="{{ $data['aboutSection2']['description'] }}"
         />
@endsection