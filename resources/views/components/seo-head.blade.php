@props(['seo' => []])

@php
    $title = $seo['title'] ?? config('app.name');
    $description = $seo['description'] ?? '';
    $keywords = $seo['keywords'] ?? '';
    $canonical = $seo['canonical'] ?? url()->current();
    $image = $seo['image'] ?? asset('images/fevicon.png');
    $type = $seo['type'] ?? 'website';
    $siteName = $seo['site_name'] ?? config('seo.platform.name', config('app.name'));
    $locale = $seo['locale'] ?? 'en_ET';
    $robots = $seo['robots'] ?? (config('app.env') === 'production' ? 'index, follow' : 'noindex, nofollow');
    $twitterSite = $seo['twitter_site'] ?? config('seo.platform.twitter');
    $localeOg = str_replace('_', '-', $locale);
@endphp

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
@if($keywords)
    <meta name="keywords" content="{{ $keywords }}">
@endif
<meta name="robots" content="{{ $robots }}">
<link rel="canonical" href="{{ $canonical }}">

<meta property="og:type" content="{{ $type }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:image" content="{{ $image }}">
<meta property="og:locale" content="{{ $localeOg }}">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $image }}">
@if($twitterSite)
    <meta name="twitter:site" content="{{ $twitterSite }}">
@endif

<meta name="geo.region" content="ET">
<meta name="geo.placename" content="Ethiopia">

@stack('seo')
