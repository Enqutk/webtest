@extends('layouts.inner')

@section('title', 'Portfolio')
@section('eyebrow', 'Selected work')
@section('page_title', 'Portfolio')
@section('description', 'Irrigation, WASH, GIS, and resilience projects delivered by MajiWorks across East Africa.')

@section('page')
    <div class="hz-section pb-0">
        <div class="container">
            <p class="hz-lead mb-0" style="max-width: 40rem;">
                A selection of irrigation, WASH, GIS, and flood-resilience work — from solar drip pilots to wetland treatment and school packages.
            </p>
        </div>
    </div>

    <x-horizon.portfolio
        :projects="$projects"
        :categories="$categories"
        :show-filters="true"
        :show-header="false"
    />
    <x-horizon.cta />
@endsection
