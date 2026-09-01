@extends('layouts.app')

@section('title', 'Home')

@section('content')
    @php
        $hs = $data['homeSections'] ?? [];
    @endphp

    {{-- 1. Hero Section --}}
    @if($hs['hero']['is_visible'] ?? true)
        <x-horizon.hero :heroes="$heroes" :hero-config="$hs['hero'] ?? []" />
    @endif

    {{-- 2. About Section --}}
    @if($hs['about']['is_visible'] ?? true)
        <x-horizon.about :about="$data['aboutFeatures']" :features="$data['heroFeatures']" />
    @endif

    {{-- 3. Services Section --}}
    @if($hs['services']['is_visible'] ?? true)
        <x-horizon.services
            :services="$services"
            :eyebrow="$hs['services']['eyebrow'] ?? 'What we deliver'"
            :title="$hs['services']['title'] ?? 'Our services'"
            :description="$hs['services']['description'] ?? null"
            :cta-text="$hs['services']['cta_text'] ?? 'View all services'"
            :cta-url="$hs['services']['cta_url'] ?? null"
        />
    @endif

    {{-- 4. Impact Stats Section --}}
    @if($hs['stats']['is_visible'] ?? true)
        <x-horizon.stats
            :stats="$data['stats']"
            :title="$data['statsTitle']"
            :subtitle="$data['statsSubtitle']"
        />
    @endif

    {{-- 5. Portfolio Section --}}
    @if($hs['portfolio']['is_visible'] ?? true)
        <x-horizon.portfolio
            :projects="$projects"
            :eyebrow="$hs['portfolio']['eyebrow'] ?? 'Selected projects'"
            :title="$hs['portfolio']['title'] ?? 'Our projects'"
            :description="$hs['portfolio']['description'] ?? null"
            :cta-text="$hs['portfolio']['cta_text'] ?? 'View full portfolio'"
            :cta-url="$hs['portfolio']['cta_url'] ?? null"
        />
    @endif

    {{-- 6. Clients & Partners Section --}}
    @if($hs['clients']['is_visible'] ?? true)
        <x-horizon.clients
            :clients="$clients"
            :eyebrow="$hs['clients']['eyebrow'] ?? 'Trusted partners'"
            :title="$hs['clients']['title'] ?? 'Clients & partners'"
            :description="$hs['clients']['description'] ?? null"
        />
    @endif

    {{-- 7. Leadership Team Section --}}
    @if($hs['team']['is_visible'] ?? true)
        <x-horizon.team
            :team="$team"
            :eyebrow="$hs['team']['eyebrow'] ?? 'Leadership & Team'"
            :title="$hs['team']['title'] ?? 'The team behind the work'"
            :description="$hs['team']['description'] ?? null"
            :cta-text="$hs['team']['cta_text'] ?? null"
            :cta-url="$hs['team']['cta_url'] ?? null"
        />
    @endif

    {{-- 8. Call to Action Banner --}}
    @if($hs['cta']['is_visible'] ?? true)
        <x-horizon.cta
            :title="$hs['cta']['title'] ?? 'Have a project in mind?'"
            :text="$hs['cta']['description'] ?? ($data['tagline'] ?? null)"
            :button="$hs['cta']['button_text'] ?? 'Start a conversation'"
            :href="$hs['cta']['button_url'] ?? null"
        />
    @endif
@endsection

