@extends('layouts.inner')

@section('title', 'Portfolio')
@section('eyebrow', 'Selected work')
@section('page_title', 'Portfolio')
@section('description', 'Projects and engagements delivered by Veritas Afrika across infrastructure and engineering.')

@section('page')
    <x-horizon.portfolio
        :projects="$projects"
        :categories="$categories"
        :show-filters="true"
    />
    <x-horizon.cta />
@endsection
