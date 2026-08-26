@extends('layouts.app')

@section('title', 'Home')
@section('description', 'MajiWorks — climate-smart irrigation, rural WASH, flood resilience, and water-resource GIS.')

@section('content')
    <x-horizon.hero :heroes="$heroes" />
    <x-horizon.about :about="$data['aboutFeatures']" :features="$data['heroFeatures']" />
    <x-horizon.services :services="$services" />
    <x-horizon.stats
        :stats="$data['stats']"
        :title="$data['statsTitle']"
        :subtitle="$data['statsSubtitle']"
    />
    <x-horizon.portfolio :projects="$projects" />
    <x-horizon.clients :clients="$clients" />
    <x-horizon.team :team="$team" />
    <x-horizon.cta />
@endsection
