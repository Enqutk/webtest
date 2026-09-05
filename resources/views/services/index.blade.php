@extends('layouts.inner')

@php
    $servicesPage = $data['sitePages']['services'] ?? [];
    $layout = $servicesPage['layout'] ?? ($data['homeSections']['services']['layout'] ?? 'cards');
    $icons = $servicesPage['icons'] ?? [];
@endphp

@section('title', $servicesPage['title'] ?? 'Our Services')
@section('eyebrow', $servicesPage['eyebrow'] ?? 'What we do')
@section('page_title', $servicesPage['title'] ?? 'Our Services')
@section('description', $servicesPage['description'] ?? ($data['metaDescription'] ?? ($data['tagline'] ?? '')))

@section('page')
    <x-horizon.services
        :services="$services"
        :show-header="false"
        :layout="$layout"
        :icons="$icons"
    />
    <x-horizon.cta
        :title="$data['homeSections']['cta']['title'] ?? null"
        :text="$data['homeSections']['cta']['description'] ?? null"
        :button="$data['homeSections']['cta']['button_text'] ?? 'Start a conversation'"
        :href="$data['homeSections']['cta']['button_url'] ?? ($data['contactUrl'] ?? null)"
    />
@endsection
