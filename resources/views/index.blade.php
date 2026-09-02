@extends('layouts.app')

@section('title', $data['homeSections']['hero']['title'] ?? 'Home')
@section('description', $data['metaDescription'] ?? ($data['siteName'] ?? ''))

@section('content')
    <x-horizon.hero :heroes="$heroes" />
    <x-horizon.about />
    <x-horizon.services :services="$services" />
    <x-horizon.stats />
    <x-horizon.portfolio :projects="$projects" />
    <x-horizon.clients :clients="$clients" />
    <x-horizon.team :team="$team" />
    <x-horizon.cta />
@endsection
