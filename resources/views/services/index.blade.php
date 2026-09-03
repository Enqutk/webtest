@extends('layouts.inner')

@php
    $servicesPage = $data['sitePages']['services'] ?? [];
@endphp

@section('title', $servicesPage['title'] ?? 'Our Services')
@section('eyebrow', $servicesPage['eyebrow'] ?? 'What we do')
@section('page_title', $servicesPage['title'] ?? 'Our Services')
@section('description', $servicesPage['description'] ?? ($data['metaDescription'] ?? ($data['tagline'] ?? '')))

@section('page')
    <x-horizon.services :services="$services" :show-header="false" />
    <x-horizon.cta />
@endsection
