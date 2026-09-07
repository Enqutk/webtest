@extends('errors.layout')

@section('title', 'Something went wrong')
@section('nav_meta', 'Error 500')
@section('code', '500')
@section('eyebrow', 'A brief interruption')
@section('heading', 'Something went wrong on our side')
@section('message', 'We could not complete that request. Please try again in a moment. If it keeps happening, come back home and start from there.')

@section('actions')
    <a class="error-btn error-btn--primary" href="{{ url('/') }}">Back home</a>
    <a class="error-btn error-btn--ghost" href="{{ url()->current() }}">Try again</a>
@endsection
