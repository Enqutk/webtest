@extends('layouts.app')

@section('seo_title', ($data['siteName'] ?? 'Profile') . ' | ' . (config('seo.tenant.title_suffix') ?? 'Digital Profile'))
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
    $defaultSectionOrder = ['hero', 'about', 'services', 'spotlight', 'stats', 'portfolio', 'gallery', 'clients', 'team', 'cta', 'inquiry'];
    $allowedSections = $defaultSectionOrder;
    $configuredOrder = $data['theme']['section_order'] ?? null;
    $sectionOrder = is_array($configuredOrder)
        ? array_values(array_filter($configuredOrder, fn ($key) => in_array($key, $allowedSections, true)))
        : $defaultSectionOrder;
    if ($sectionOrder === []) {
        $sectionOrder = $defaultSectionOrder;
    }
@endphp

@foreach ($sectionOrder as $sectionKey)
@switch($sectionKey)
@case('hero')
    @if(!isset($hs['hero']['is_visible']) || !empty($hs['hero']['is_visible']))
        @if(($hs['hero']['style'] ?? 'split') === 'backdrop')
            <x-horizon.ceremony-hero :hero-config="$hs['hero'] ?? []" />
        @else
            <x-horizon.hero :heroes="$heroes" :hero-config="$hs['hero'] ?? []" />
        @endif
    @endif
    @break

@case('about')
    @if(!isset($hs['about']['is_visible']) || !empty($hs['about']['is_visible']))
        @if(($hs['about']['layout'] ?? 'default') === 'editorial')
            <x-horizon.ceremony-about
                :about="array_merge($data['aboutFeatures'] ?? [], [
                    'title' => $hs['about']['title'] ?? ($data['aboutFeatures']['title'] ?? null),
                    'subtitle' => $hs['about']['eyebrow'] ?? ($data['aboutFeatures']['subtitle'] ?? null),
                    'description' => $aboutCopy !== '' ? nl2br(e($aboutCopy)) : ($data['aboutFeatures']['description'] ?? ''),
                    'points' => $hs['about']['points'] ?? $data['aboutFeatures']['points'] ?? [],
                ])"
                :config="$hs['about'] ?? []"
            />
        @else
        <x-horizon.about
            :about="array_merge($data['aboutFeatures'] ?? [], [
                'title' => $hs['about']['title'] ?? ($data['aboutFeatures']['title'] ?? null),
                'subtitle' => $hs['about']['eyebrow'] ?? ($data['aboutFeatures']['subtitle'] ?? null),
                'description' => $aboutCopy !== '' ? nl2br(e($aboutCopy)) : ($data['aboutFeatures']['description'] ?? ''),
                'points' => $hs['about']['points'] ?? $data['aboutFeatures']['points'] ?? [],
                'kicker' => $hs['about']['kicker'] ?? ($data['aboutFeatures']['kicker'] ?? 'Me'),
                'portrait_role' => $hs['about']['portrait_role'] ?? ($data['aboutFeatures']['portrait_role'] ?? null),
            ])"
            :features="$data['heroFeatures'] ?? null"
            :layout="$hs['about']['layout'] ?? ($data['sitePages']['about']['layout'] ?? 'default')"
            :link-text="$hs['about']['cta_text'] ?? 'More about us'"
            :link-url="$hs['about']['cta_url'] ?? ($data['aboutUrl'] ?? null)"
        />
        @endif
    @endif
    @break

@case('services')
    @if(!isset($hs['services']['is_visible']) || !empty($hs['services']['is_visible']))
        @if(($hs['services']['layout'] ?? ($data['sitePages']['services']['layout'] ?? 'cards')) === 'outline')
            <x-horizon.ceremony-services
                :services="$services"
                :config="$hs['services'] ?? []"
                :icons="$hs['services']['icons'] ?? ($data['sitePages']['services']['icons'] ?? [])"
            />
        @else
        <x-horizon.services
            :services="$services"
            :eyebrow="$hs['services']['eyebrow'] ?? 'What we deliver'"
            :title="$hs['services']['title'] ?? 'Our services'"
            :description="$hs['services']['description'] ?? null"
            :cta-text="$hs['services']['cta_text'] ?? 'All services'"
            :cta-url="$hs['services']['cta_url'] ?? ($data['servicesUrl'] ?? null)"
            :layout="$hs['services']['layout'] ?? ($data['sitePages']['services']['layout'] ?? 'cards')"
            :icons="$hs['services']['icons'] ?? ($data['sitePages']['services']['icons'] ?? [])"
        />
        @endif
    @endif
    @break

@case('stats')
    @if(!isset($hs['stats']['is_visible']) || !empty($hs['stats']['is_visible']))
        <x-horizon.stats
            :stats="$data['stats'] ?? []"
            :title="$hs['stats']['title'] ?? ($data['statsTitle'] ?? 'Impact that compounds')"
            :subtitle="$hs['stats']['eyebrow'] ?? ($data['statsSubtitle'] ?? 'By the numbers')"
            :variant="$hs['stats']['variant'] ?? 'dark'"
        />
    @endif
    @break

@case('portfolio')
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
    @break

@case('clients')
    @if(!isset($hs['clients']['is_visible']) || !empty($hs['clients']['is_visible']))
        <x-horizon.clients
            :clients="$clients"
            :eyebrow="$hs['clients']['eyebrow'] ?? 'Trusted by'"
            :title="$hs['clients']['title'] ?? 'Clients & partners'"
            :description="$hs['clients']['description'] ?? null"
        />
    @endif
    @break

@case('team')
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
    @break

@case('spotlight')
    @if(!isset($hs['spotlight']['is_visible']) || !empty($hs['spotlight']['is_visible']))
        <x-horizon.ceremony-spotlight :config="$hs['spotlight'] ?? []" />
    @endif
    @break

@case('gallery')
    @if(!isset($hs['gallery']['is_visible']) || !empty($hs['gallery']['is_visible']))
        <x-horizon.ceremony-gallery :config="$hs['gallery'] ?? []" />
    @endif
    @break

@case('inquiry')
    @if(!isset($hs['inquiry']['is_visible']) || !empty($hs['inquiry']['is_visible']))
        <x-horizon.ceremony-inquiry :config="$hs['inquiry'] ?? []" />
    @endif
    @break

@case('cta')
    @if(!isset($hs['cta']['is_visible']) || !empty($hs['cta']['is_visible']))
        @if(($hs['cta']['style'] ?? 'band') === 'center')
            <x-horizon.ceremony-cta :config="$hs['cta'] ?? []" />
        @else
        <x-horizon.cta
            :title="$hs['cta']['title'] ?? 'Have a project in mind?'"
            :text="$hs['cta']['description'] ?? null"
            :button="$hs['cta']['button_text'] ?? 'Start a conversation'"
            :href="$hs['cta']['button_url'] ?? null"
        />
        @endif
    @endif
    @break
@endswitch
@endforeach
@endsection
