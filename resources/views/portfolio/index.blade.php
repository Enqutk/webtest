@extends('layouts.inner')

@php
    $portfolioPage = $data['sitePages']['portfolio'] ?? [];
@endphp

@section('title', $portfolioPage['title'] ?? 'Portfolio')
@section('eyebrow', $portfolioPage['eyebrow'] ?? 'Selected work')
@section('page_title', $portfolioPage['title'] ?? 'Portfolio')
@section('description', $portfolioPage['description'] ?? ($data['metaDescription'] ?? ($data['tagline'] ?? '')))

@section('page')
    @if(($portfolioPage['description'] ?? null) || ($data['tagline'] ?? null))
        <div class="hz-section pb-0">
            <div class="container">
                <p class="hz-lead mb-0" style="max-width: 40rem;">
                    {{ $portfolioPage['description'] ?? $data['tagline'] }}
                </p>
            </div>
        </div>
    @endif

    <x-horizon.portfolio
        :projects="$projects"
        :categories="$categories"
        :show-filters="true"
        :show-header="false"
    />
    <x-horizon.cta />
@endsection
