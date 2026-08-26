<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Home') | Veritas Afrika</title>
    <meta name="description" content="@yield('description', 'Veritas Afrika — professional consultancy for civil engineering and infrastructure development.')">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/fevicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    @include('layouts.horizon.header')

    <main>
        @yield('content')
    </main>

    @include('layouts.horizon.footer')

    @stack('scripts')
</body>
</html>
