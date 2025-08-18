@extends('layouts.app')

@section('content')
    <x-blog-section :posts="$blogPosts" />
@endsection
