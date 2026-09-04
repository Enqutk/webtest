@extends('layouts.inner')

@php
    $aboutPage = $data['sitePages']['about'] ?? [];
@endphp

@section('title', $aboutPage['title'] ?? 'About Us')
@section('eyebrow', $aboutPage['eyebrow'] ?? 'Who we are')
@section('page_title', $aboutPage['title'] ?? ('About ' . ($data['siteName'] ?? config('app.name'))))
@section('description', $aboutPage['description'] ?? ($data['metaDescription'] ?? ($data['tagline'] ?? '')))

@section('page')
    <x-horizon.about
        :about="$data['aboutFeatures']"
        :features="$data['heroFeatures']"
        :show-link="false"
        preview-context="about-page"
    />

    @if($data['aboutSection1'] || $data['aboutSection2'])
        <section
            class="hz-section hz-about-story bg-surface border-top border-bottom border-hz"
            id="about-page-story"
            @if(request()->boolean('admin_preview'))
                data-admin-section="about-page-story"
                data-admin-label="Edit Story Section"
                data-admin-edit-url="{{ route('admin.site-pages.edit', 'about') }}#about-page-story"
            @endif
        >
            <div class="container">
                <div class="row justify-content-center mb-4">
                    <div class="col-lg-8 text-center">
                        <p class="hz-eyebrow" data-preview-field="eyebrow" {!! \App\Support\AdminPreviewAttrs::html('about-page-story', 'eyebrow', 'Edit Eyebrow', true, route('admin.site-pages.edit', 'about') . '#about-page-story') !!}>{{ $aboutPage['story']['eyebrow'] ?? 'Our story' }}</p>
                        <h2 class="hz-title" data-preview-field="title" {!! \App\Support\AdminPreviewAttrs::html('about-page-story', 'title', 'Edit Heading', true, route('admin.site-pages.edit', 'about') . '#about-page-story') !!}>{{ $aboutPage['story']['title'] ?? 'How we work' }}</h2>
                    </div>
                </div>
                <div class="row g-4">
                    @if($data['aboutSection1'])
                        <div class="col-lg-6">
                            <article class="hz-about-panel">
                                @if(!empty($data['aboutSection1']['image']))
                                    <div class="hz-about-panel-media">
                                        <img
                                            src="{{ $data['aboutSection1']['image'] }}"
                                            alt="{{ $data['aboutSection1']['title'] ?? 'Our practice' }}"
                                        >
                                    </div>
                                @endif
                                <div class="hz-about-panel-body">
                                    <h3 class="h4 mb-3">{{ $data['aboutSection1']['title'] ?? 'Our practice' }}</h3>
                                    <div class="hz-lead mb-0">{!! $data['aboutSection1']['description'] !!}</div>
                                </div>
                            </article>
                        </div>
                    @endif
                    @if($data['aboutSection2'])
                        <div class="col-lg-6">
                            <article class="hz-about-panel">
                                @if(!empty($data['aboutSection2']['image']))
                                    <div class="hz-about-panel-media">
                                        <img
                                            src="{{ $data['aboutSection2']['image'] }}"
                                            alt="{{ $data['aboutSection2']['title'] ?? 'Our approach' }}"
                                        >
                                    </div>
                                @endif
                                <div class="hz-about-panel-body">
                                    <h3 class="h4 mb-3">{{ $data['aboutSection2']['title'] ?? 'Our approach' }}</h3>
                                    <div class="hz-lead mb-0">{!! $data['aboutSection2']['description'] !!}</div>
                                </div>
                            </article>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    @if($aboutPage['show_stats'] ?? true)
        <x-horizon.stats
            :stats="$data['stats']"
            :title="$data['statsTitle']"
            :subtitle="$data['statsSubtitle']"
        />
    @endif
    @if($aboutPage['show_team'] ?? true)
        <x-horizon.team :team="$team" :show-bios="true" />
    @endif
    @if($aboutPage['show_clients'] ?? true)
        <x-horizon.clients :clients="$clients" />
    @endif
    @if($aboutPage['show_cta'] ?? true)
        <x-horizon.cta />
    @endif
@endsection
