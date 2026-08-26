@extends('layouts.inner')

@section('title', 'Our Services')
@section('eyebrow', 'What we do')
@section('page_title', 'Our Services')
@section('description', 'Irrigation, WASH, drainage, GIS, solar pumping, and governance services from MajiWorks.')

@section('page')
    <x-horizon.services :services="$services" :show-header="false" />
    <x-horizon.cta />
@endsection
