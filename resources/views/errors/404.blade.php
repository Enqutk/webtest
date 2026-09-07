@extends('errors.layout')

@php
    $homeUrl = url('/');
    $profileUrl = null;
    $path = ltrim(request()->path(), '/');
    if (preg_match('#^card/([A-Za-z0-9\-]+)#', $path, $matches)) {
        $profileUrl = url('/card/'.$matches[1]);
    }
@endphp

@section('title', 'Page not found')
@section('nav_meta', 'Error 404')
@section('code', '404')
@section('eyebrow', 'Lost signal')
@section('heading', 'This page is not on the map')
@section('message', 'The link may be mistyped, expired, or the page may have moved. Head back and we will get you where you need to go.')

@section('actions')
    @if($profileUrl)
        <a class="error-btn error-btn--primary" href="{{ $profileUrl }}">Back to profile</a>
        <a class="error-btn error-btn--ghost" href="{{ $homeUrl }}">Kimem home</a>
    @else
        <a class="error-btn error-btn--primary" href="{{ $homeUrl }}">Back home</a>
        <a class="error-btn error-btn--ghost" href="{{ url('/apply') }}">Order a card</a>
    @endif
@endsection
