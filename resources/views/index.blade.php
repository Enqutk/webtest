@extends('layouts.app')

@section('title', 'Home')
@section('description', 'Veritas Afrika — multi-disciplinary consultancy for civil engineering and infrastructure development.')

@section('content')
    <x-horizon.hero :heroes="$heroes" />
    <x-horizon.about :about="$data['aboutFeatures']" :features="$data['heroFeatures']" />
    <x-horizon.services :services="$services" />
    <x-horizon.stats :stats="$data['stats']" />
    <x-horizon.portfolio :projects="$projects" />
    <x-horizon.clients :clients="$clients" />
    <x-horizon.team :team="$team" />
    <x-horizon.cta />
@endsection
