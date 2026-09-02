@extends('admin.layouts.app')

@section('title', 'Organizations')
@section('page-title', 'Organizations & Tenants Hub')
@section('page-subtitle', 'Select an organization to adjust its website, hero banner, services, and team')

@section('content')
<div class="space-y-6">

    <!-- Workflow Banner -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 text-white rounded-2xl p-6 shadow-md border border-slate-700/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="space-y-1">
            <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-brand-500/20 text-brand-300 text-[11px] font-bold">
                <i class="bi bi-diagram-3-fill"></i>
                <span>STEP 1: SELECT ORGANIZATION &bull; STEP 2: ADJUST CONTENT</span>
            </div>
            <h2 class="text-xl font-bold text-white tracking-tight">Multi-Tenant Management Hub</h2>
            <p class="text-xs text-slate-400 max-w-xl">
                Select an organization below to customize its hero slides, about section, team, brand colors, and picture shapes.
            </p>
        </div>
        <a href="{{ route('admin.organizations.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30 transition shrink-0">
            <i class="bi bi-plus-circle-fill"></i>
            <span>Add New Organization</span>
        </a>
    </div>

    <!-- Organizations Grid Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($organizations as $org)
            @php
                $isActiveTenant = ($org->id === $currentOrg->id);
                $logo = $org->getFirstMediaUrl('logo');
            @endphp
            <div class="bg-white rounded-2xl border-2 {{ $isActiveTenant ? 'border-brand-500 ring-4 ring-brand-500/10 shadow-lg' : 'border-slate-200/80 shadow-sm' }} p-6 flex flex-col justify-between hover:shadow-md transition">
                <div>
                    <!-- Card Top Header -->
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="flex items-center gap-3.5">
                            <div class="w-14 h-14 rounded-2xl bg-slate-100 border border-slate-200 flex items-center justify-center font-bold text-lg text-brand-600 overflow-hidden shrink-0 shadow-inner">
                                @if($logo)
                                    <img src="{{ $logo }}" alt="{{ $org->title }}" class="w-full h-full object-cover">
                                @else
                                    {{ mb_substr($org->title, 0, 2) }}
                                @endif
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900 leading-tight">{{ $org->title }}</h3>
                                <span class="text-[11px] font-mono text-brand-600 font-semibold block mt-0.5">slug: /{{ $org->slug }}</span>
                            </div>
                        </div>

                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $org->status === 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600' }}">
                            {{ ucfirst($org->status) }}
                        </span>
                    </div>

                    <!-- Active Badge indicator -->
                    @if($isActiveTenant)
                        <div class="mb-4 p-2 rounded-xl bg-brand-50 border border-brand-200 text-brand-800 text-xs font-bold flex items-center justify-between">
                            <div class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span>
                                <span>CURRENTLY ACTIVE FOR ADJUSTMENTS</span>
                            </div>
                            <i class="bi bi-check-circle-fill text-brand-600"></i>
                        </div>
                    @endif

                    @if($org->tagline)
                        <p class="text-xs text-slate-600 mb-4 line-clamp-2 italic">"{{ $org->tagline }}"</p>
                    @endif

                    <!-- Stats breakdown -->
                    <div class="grid grid-cols-3 gap-2 py-3 border-y border-slate-100 text-center mb-5 bg-slate-50/60 rounded-xl">
                        <div class="p-1.5">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block">Team</span>
                            <span class="text-xs font-bold text-slate-800">{{ $org->teams_count ?? 0 }}</span>
                        </div>
                        <div class="p-1.5 border-x border-slate-200/60">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block">Services</span>
                            <span class="text-xs font-bold text-slate-800">{{ $org->services_count ?? 0 }}</span>
                        </div>
                        <div class="p-1.5">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block">Projects</span>
                            <span class="text-xs font-bold text-slate-800">{{ $org->entities_count ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actionable Adjustment Hub Buttons -->
                <div class="space-y-2 pt-2">
                    <!-- Primary Adjustment Action -->
                    <a href="{{ route('admin.home-sections.index', ['org' => $org->id]) }}"
                       class="w-full py-2.5 px-3 rounded-xl text-xs font-bold text-center flex items-center justify-center gap-2 transition {{ $isActiveTenant ? 'bg-brand-600 hover:bg-brand-500 text-white shadow-md shadow-brand-600/30' : 'bg-slate-900 hover:bg-slate-800 text-white' }}">
                        <i class="bi bi-layout-text-window-reverse"></i>
                        <span>Adjust Hero & Home Page</span>
                    </a>

                    <!-- Secondary Quick Actions -->
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('admin.organizations.edit', $org) }}" class="py-2 px-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl text-center transition flex items-center justify-center gap-1.5">
                            <i class="bi bi-palette"></i>
                            <span>Brand & Colors</span>
                        </a>
                        <a href="{{ route('card.home', ['slug' => $org->slug ?: \Illuminate\Support\Str::slug($org->title) ?: 'default']) }}" target="_blank" class="py-2 px-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl text-center transition flex items-center justify-center gap-1.5">
                            <i class="bi bi-box-arrow-up-right"></i>
                            <span>View Card Site</span>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
