@extends('layouts.app')

@section('content')
<!-- Page Content -->
<div class="page-content mb-4">
    {{-- <!-- Hero Features Section -->
    <div class="mt-5 mb-5">
        <x-hero-features :features="$data['heroFeatures']?->list_items ?? []" />
    </div> --}}

    {{-- <hr> --}}

    <!-- About Section -->
    @if($data['aboutFeatures'])
    <x-about-section
        :image="$data['aboutFeatures']['image']"
        :subtitle="$data['aboutFeatures']['subtitle']"
        :title="$data['aboutFeatures']['title']"
        :description="$data['aboutFeatures']['description']" />
    @endif

    <x-service-section :services="$services" />

    
</div>
<!-- Page Content End -->
@endsection