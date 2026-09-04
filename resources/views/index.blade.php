@extends('layouts.app')

@section('title', $data['homeSections']['hero']['title'] ?? 'Home')
@section('description', $data['metaDescription'] ?? ($data['siteName'] ?? ''))

@section('content')
@php
    $hs = $data['homeSections'] ?? [];
    $aboutCopy = $hs['about']['description']
        ?? trim(collect([
            $hs['about']['paragraph_1'] ?? null,
            $hs['about']['paragraph_2'] ?? null,
        ])->filter()->implode("\n\n"));
@endphp

    @if(!isset($hs['hero']['is_visible']) || !empty($hs['hero']['is_visible']))
        <x-horizon.hero :heroes="$heroes" :hero-config="$hs['hero'] ?? []" />
    @endif

    @if(!isset($hs['about']['is_visible']) || !empty($hs['about']['is_visible']))
        <x-horizon.about
            :about="array_merge($data['aboutFeatures'] ?? [], [
                'title' => $hs['about']['title'] ?? ($data['aboutFeatures']['title'] ?? null),
                'subtitle' => $hs['about']['eyebrow'] ?? ($data['aboutFeatures']['subtitle'] ?? null),
                'description' => $aboutCopy !== '' ? nl2br(e($aboutCopy)) : ($data['aboutFeatures']['description'] ?? ''),
            ])"
            :features="$data['heroFeatures'] ?? null"
        />
    @endif

    @if(!isset($hs['services']['is_visible']) || !empty($hs['services']['is_visible']))
        <x-horizon.services
            :services="$services"
            :eyebrow="$hs['services']['eyebrow'] ?? 'What we deliver'"
            :title="$hs['services']['title'] ?? 'Our services'"
            :description="$hs['services']['description'] ?? null"
            :cta-text="$hs['services']['cta_text'] ?? 'All services'"
            :cta-url="$hs['services']['cta_url'] ?? null"
        />
    @endif

    @if(!isset($hs['stats']['is_visible']) || !empty($hs['stats']['is_visible']))
        <x-horizon.stats
            :stats="$data['stats'] ?? []"
            :title="$hs['stats']['title'] ?? ($data['statsTitle'] ?? 'Impact that compounds')"
            :subtitle="$hs['stats']['eyebrow'] ?? ($data['statsSubtitle'] ?? 'By the numbers')"
        />
    @endif

    @if(!isset($hs['portfolio']['is_visible']) || !empty($hs['portfolio']['is_visible']))
        <x-horizon.portfolio
            :projects="$projects"
            :eyebrow="$hs['portfolio']['eyebrow'] ?? 'Selected projects'"
            :title="$hs['portfolio']['title'] ?? 'Our projects'"
            :description="$hs['portfolio']['description'] ?? null"
            :cta-text="$hs['portfolio']['cta_text'] ?? 'View full portfolio'"
            :cta-url="$hs['portfolio']['cta_url'] ?? null"
        />
    @endif

    @if(!isset($hs['clients']['is_visible']) || !empty($hs['clients']['is_visible']))
        <x-horizon.clients
            :clients="$clients"
            :eyebrow="$hs['clients']['eyebrow'] ?? 'Trusted by'"
            :title="$hs['clients']['title'] ?? 'Clients & partners'"
            :description="$hs['clients']['description'] ?? null"
        />
    @endif

    @if(!isset($hs['team']['is_visible']) || !empty($hs['team']['is_visible']))
        <x-horizon.team
            :team="$team"
            :eyebrow="$hs['team']['eyebrow'] ?? 'Our people'"
            :title="$hs['team']['title'] ?? 'The team behind the work'"
            :description="$hs['team']['description'] ?? null"
            :cta-text="$hs['team']['cta_text'] ?? null"
            :cta-url="$hs['team']['cta_url'] ?? null"
        />
    @endif

    @if(!isset($hs['cta']['is_visible']) || !empty($hs['cta']['is_visible']))
        <x-horizon.cta
            :title="$hs['cta']['title'] ?? 'Have a project in mind?'"
            :text="$hs['cta']['description'] ?? null"
            :button="$hs['cta']['button_text'] ?? 'Start a conversation'"
            :href="$hs['cta']['button_url'] ?? null"
        />
    @endif
@endsection
