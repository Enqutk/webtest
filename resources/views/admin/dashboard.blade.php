@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Overview & Analytics')
@section('page-subtitle', $currentOrg->title ?? 'Organization')

@section('content')
<div class="space-y-6">

    <!-- Hero Welcome Banner -->
    <div class="relative overflow-hidden bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 text-white rounded-2xl p-6 lg:p-8 shadow-md border border-slate-700/50">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-brand-500/20 text-brand-300 text-[11px] font-bold tracking-wide">
                    <span class="w-2 h-2 rounded-full bg-brand-400 animate-pulse"></span>
                    ACTIVE TENANT: {{ strtoupper($currentOrg->title ?? 'DEFAULT') }}
                </div>
                <h2 class="text-2xl font-bold text-white tracking-tight">Welcome back, {{ auth()->user()->name ?? 'Administrator' }}</h2>
                <p class="text-slate-400 text-xs max-w-xl">
                    Manage your homepage banner, leadership team, services portfolio, brand styles, and multi-tenant organization profiles seamlessly.
                </p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('admin.home-sections.index') }}" class="px-4 py-2 bg-brand-600 hover:bg-brand-500 text-white text-xs font-bold rounded-xl shadow-lg shadow-brand-600/30 transition inline-flex items-center gap-2">
                    <i class="bi bi-magic"></i>
                    <span>Customize Home Page</span>
                </a>
                <a href="{{ route('admin.organizations.edit', $currentOrg) }}" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white text-xs font-bold rounded-xl transition inline-flex items-center gap-2">
                    <i class="bi bi-palette"></i>
                    <span>Brand & Colors</span>
                </a>
            </div>
        </div>
        
        <!-- Decorative Glow -->
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-brand-500/10 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Card 1 -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center text-xl shrink-0">
                <i class="bi bi-buildings"></i>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-500 block">Total Tenants</span>
                <span class="text-xl font-bold text-slate-900">{{ $stats['orgsCount'] }}</span>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shrink-0">
                <i class="bi bi-wrench-adjustable-circle"></i>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-500 block">Services</span>
                <span class="text-xl font-bold text-slate-900">{{ $stats['servicesCount'] }}</span>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                <i class="bi bi-people"></i>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-500 block">Team Members</span>
                <span class="text-xl font-bold text-slate-900">{{ $stats['teamCount'] }}</span>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl shrink-0">
                <i class="bi bi-briefcase"></i>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-500 block">Projects</span>
                <span class="text-xl font-bold text-slate-900">{{ $stats['projectsCount'] }}</span>
            </div>
        </div>

        <!-- Card 5 -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0">
                <i class="bi bi-file-earmark-text"></i>
            </div>
            <div>
                <span class="text-xs font-semibold text-slate-500 block">Custom Pages</span>
                <span class="text-xl font-bold text-slate-900">{{ $stats['pagesCount'] }}</span>
            </div>
        </div>
    </div>

    <!-- Quick Management Columns -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Column 1: Leadership Team on Current Tenant -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <i class="bi bi-people-fill text-sm"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Leadership Team</h3>
                        <p class="text-[11px] text-slate-500">Active team members on {{ $currentOrg->title }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.team.index') }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700">View all &rarr;</a>
            </div>

            @if($recentTeam->isEmpty())
                <div class="text-center py-8 text-slate-400 text-xs">
                    No team members created yet for this organization.
                </div>
            @else
                <div class="space-y-3">
                    @foreach($recentTeam as $member)
                        <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 hover:bg-slate-100 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-slate-200 overflow-hidden flex items-center justify-center shrink-0">
                                    @if($member->getFirstMediaUrl('team-images'))
                                        <img src="{{ $member->getFirstMediaUrl('team-images') }}" alt="{{ $member->full_name }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-xs font-bold text-slate-400">{{ mb_substr($member->first_name, 0, 1) }}</span>
                                    @endif
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-bold text-slate-900">{{ $member->full_name }}</span>
                                        @if($member->founder)
                                            <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800">FOUNDER</span>
                                        @endif
                                    </div>
                                    <span class="text-[11px] text-slate-500">{{ $member->title }}</span>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $member->status === \App\Enums\StatusEnum::active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600' }}">
                                {{ ucfirst($member->status->value ?? 'active') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Column 2: Services on Current Tenant -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-5">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                        <i class="bi bi-wrench-adjustable-circle-fill text-sm"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">Services</h3>
                        <p class="text-[11px] text-slate-500">Service offerings on {{ $currentOrg->title }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.services.index') }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700">View all &rarr;</a>
            </div>

            @if($recentServices->isEmpty())
                <div class="text-center py-8 text-slate-400 text-xs">
                    No services configured yet for this organization.
                </div>
            @else
                <div class="space-y-3">
                    @foreach($recentServices as $srv)
                        <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 hover:bg-slate-100 transition">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center font-bold text-xs shrink-0">
                                    {{ $srv->order }}
                                </div>
                                <div>
                                    <span class="text-xs font-bold text-slate-900 block">{{ $srv->title }}</span>
                                    <span class="text-[11px] text-slate-500 truncate block max-w-xs">{{ \Illuminate\Support\Str::limit($srv->short_description, 60) }}</span>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $srv->status === \App\Enums\StatusEnum::active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600' }}">
                                {{ ucfirst($srv->status->value ?? 'active') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

</div>
@endsection
