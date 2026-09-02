<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') | {{ $currentOrg->title ?? config('app.name', 'Site') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Tailwind Play CDN for ultra-fast, seamless UI -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                    colors: {
                        brand: {
                            50: '#fdf4ec',
                            100: '#fae6d3',
                            200: '#f5cba8',
                            300: '#f0ac74',
                            400: '#ea863e',
                            500: '#ea580c',
                            600: '#d54308',
                            700: '#b13009',
                            800: '#8e270e',
                            900: '#73230f',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>
    @stack('styles')
</head>
<body class="h-full font-sans antialiased text-slate-800 bg-slate-50 flex" x-data="{ sidebarOpen: false }">

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen"
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden"
         x-cloak></div>

    <!-- Sidebar Navigation -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 text-slate-300 flex flex-col transition-transform duration-300 ease-in-out lg:static shadow-xl">
        
        <!-- Brand / App Logo -->
        <div class="h-16 px-6 flex items-center justify-between border-b border-slate-800/80 bg-slate-950/40">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-brand-600 to-amber-500 flex items-center justify-center text-white shadow-md shadow-brand-500/20">
                    <i class="bi bi-grid-fill text-lg"></i>
                </div>
                <div>
                    <span class="font-bold text-white tracking-tight text-base block leading-tight">Admin Studio</span>
                    <span class="text-[10px] text-slate-400 font-mono uppercase tracking-wider">Multi-Tenant Platform</span>
                </div>
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white p-1">
                <i class="bi bi-x-lg text-lg"></i>
            </button>
        </div>

        <!-- Tenant Switcher Widget -->
        @php
            $activeOrg = $currentOrg ?? \App\Models\Organization::resolveCurrent();
            $availableOrgs = \App\Models\Organization::all();
        @endphp
        <div class="p-3 border-b border-slate-800/60">
            <div class="bg-slate-800/50 rounded-xl p-2.5 border border-slate-700/50" x-data="{ openTenantDropdown: false }">
                <div class="flex items-center justify-between cursor-pointer" @click="openTenantDropdown = !openTenantDropdown">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="w-8 h-8 rounded-lg bg-brand-500/20 border border-brand-500/30 flex items-center justify-center text-brand-400 font-bold text-xs shrink-0 overflow-hidden">
                            @if($activeOrg->getFirstMediaUrl('logo'))
                                <img src="{{ $activeOrg->getFirstMediaUrl('logo') }}" alt="logo" class="w-full h-full object-cover">
                            @else
                                {{ mb_substr($activeOrg->title ?? 'O', 0, 1) }}
                            @endif
                        </div>
                        <div class="min-w-0">
                            <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider block">Active Tenant</span>
                            <span class="text-xs font-semibold text-white truncate block">{{ $activeOrg->title ?? 'Select Organization' }}</span>
                        </div>
                    </div>
                    <i class="bi bi-chevron-expand text-slate-400 text-xs ml-2"></i>
                </div>

                <!-- Dropdown list -->
                <div x-show="openTenantDropdown" @click.away="openTenantDropdown = false" x-transition class="mt-2.5 pt-2.5 border-t border-slate-700/50 space-y-1" x-cloak>
                    <div class="text-[10px] text-slate-400 font-semibold px-2 py-1">Switch Organization:</div>
                    @foreach($availableOrgs as $org)
                        <form action="{{ route('admin.organizations.switch', $org) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-2.5 py-1.5 rounded-lg text-xs flex items-center justify-between {{ $org->id === $activeOrg->id ? 'bg-brand-500/20 text-brand-300 font-bold' : 'hover:bg-slate-700/50 text-slate-300' }}">
                                <span class="truncate">{{ $org->title }}</span>
                                @if($org->id === $activeOrg->id)
                                    <i class="bi bi-check2 text-brand-400"></i>
                                @endif
                            </button>
                        </form>
                    @endforeach
                    <a href="{{ route('admin.organizations.create') }}" class="mt-2 block w-full text-center px-2 py-1.5 bg-slate-700 hover:bg-slate-600 text-white rounded-lg text-[11px] font-semibold transition">
                        <i class="bi bi-plus-circle mr-1"></i> Add New Organization
                    </a>
                </div>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-3 py-4 space-y-6 overflow-y-auto custom-scrollbar">
            
            <!-- Group: Overview -->
            <div>
                <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">Main</div>
                <div class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="bi bi-speedometer2 text-base"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
            </div>

            <!-- Group: Website Content -->
            <div>
                <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">Website Content & Sections</div>
                <div class="space-y-1">
                    <a href="{{ route('admin.home-sections.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.home-sections.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="bi bi-layout-text-window-reverse text-base"></i>
                        <span>Home Page Sections</span>
                    </a>
                    <a href="{{ route('admin.team.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.team.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="bi bi-people-fill text-base"></i>
                        <span>Leadership Team</span>
                    </a>
                    <a href="{{ route('admin.services.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.services.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="bi bi-wrench-adjustable-circle-fill text-base"></i>
                        <span>Services</span>
                    </a>
                    <a href="{{ route('admin.portfolio.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.portfolio.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="bi bi-briefcase-fill text-base"></i>
                        <span>Portfolio Projects</span>
                    </a>
                    <a href="{{ route('admin.pages.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.pages.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="bi bi-file-earmark-text-fill text-base"></i>
                        <span>Custom Pages</span>
                    </a>
                </div>
            </div>

            <!-- Group: Menus & Navigation -->
            <div>
                <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">Menus & Social</div>
                <div class="space-y-1">
                    <a href="{{ route('admin.menus.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.menus.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="bi bi-menu-button-wide-fill text-base"></i>
                        <span>Navigation Menus</span>
                    </a>
                    <a href="{{ route('admin.socials.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.socials.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="bi bi-share-fill text-base"></i>
                        <span>Social Media Links</span>
                    </a>
                </div>
            </div>

            <!-- Group: Multi-Tenancy & Management -->
            <div>
                <div class="px-3 text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-2">Management & Settings</div>
                <div class="space-y-1">
                    <a href="{{ route('admin.organizations.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.organizations.index') || request()->routeIs('admin.organizations.create') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="bi bi-buildings-fill text-base"></i>
                        <span>Organizations & Tenants</span>
                    </a>
                    <a href="{{ route('admin.organizations.edit', $activeOrg) }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-semibold transition {{ request()->is('admin/organizations/'.$activeOrg->id.'/edit') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="bi bi-palette-fill text-base"></i>
                        <span>Brand & Styling Settings</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.users.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <i class="bi bi-people-fill text-base"></i>
                        <span>Users & Access</span>
                    </a>
                </div>
            </div>
        </nav>

        <!-- User / Logout Footer -->
        <div class="p-3 border-t border-slate-800/80 bg-slate-950/40">
            <div class="flex items-center justify-between p-2 rounded-xl bg-slate-800/40">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center text-white font-bold text-xs shrink-0">
                        {{ mb_substr(auth()->user()->name ?? 'U', 0, 1) }}
                    </div>
                    <div class="min-w-0">
                        <span class="text-xs font-semibold text-white truncate block">{{ auth()->user()->name ?? 'Administrator' }}</span>
                        <span class="text-[10px] text-slate-400 truncate block">{{ auth()->user()->email ?? '' }}</span>
                    </div>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" title="Log Out" class="p-1.5 text-slate-400 hover:text-rose-400 transition">
                        <i class="bi bi-box-arrow-right text-base"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        
        <!-- Topbar Header -->
        <header class="h-16 bg-white border-b border-slate-200 px-4 lg:px-8 flex items-center justify-between shrink-0 shadow-sm">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100">
                    <i class="bi bi-list text-xl"></i>
                </button>
                <div class="flex items-center gap-2">
                    <h1 class="text-base font-bold text-slate-900">@yield('page-title', 'Dashboard')</h1>
                    @hasSection('page-subtitle')
                        <span class="text-slate-300">/</span>
                        <span class="text-xs text-slate-500 font-medium">@yield('page-subtitle')</span>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-3">
                <!-- Prominent Organization Selector Widget in Topbar -->
                <div class="relative" x-data="{ topbarOrgDropdown: false }">
                    <button @click="topbarOrgDropdown = !topbarOrgDropdown" type="button" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-800 text-xs font-bold transition shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-brand-500"></span>
                        <span class="text-slate-400 font-normal hidden md:inline">Tenant:</span>
                        <span class="truncate max-w-[140px]">{{ $activeOrg->title ?? 'Select Org' }}</span>
                        <i class="bi bi-chevron-down text-[10px] text-slate-400"></i>
                    </button>

                    <div x-show="topbarOrgDropdown" @click.away="topbarOrgDropdown = false" x-transition class="absolute right-0 mt-1.5 w-64 bg-white border border-slate-200 rounded-xl shadow-xl p-1.5 z-50 space-y-1" x-cloak>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider px-2 py-1">Switch Active Organization:</div>
                        @foreach($availableOrgs as $org)
                            <form action="{{ route('admin.organizations.switch', $org) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-2.5 py-1.5 rounded-lg text-xs flex items-center justify-between {{ $org->id === $activeOrg->id ? 'bg-brand-50 text-brand-700 font-bold' : 'hover:bg-slate-50 text-slate-700' }}">
                                    <span class="truncate">{{ $org->title }}</span>
                                    @if($org->id === $activeOrg->id)
                                        <i class="bi bi-check2 text-brand-600"></i>
                                    @endif
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>

                <!-- Public Website Quick Link -->
                <a href="{{ url('/') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg transition">
                    <i class="bi bi-box-arrow-up-right text-xs"></i>
                    <span class="hidden sm:inline">View Public Website</span>
                </a>

                <!-- User Avatar -->
                <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-brand-500 to-amber-500 flex items-center justify-center text-white font-bold text-xs shadow-sm">
                    {{ mb_substr(auth()->user()->name ?? 'U', 0, 1) }}
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mx-4 lg:mx-8 mt-4 p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl flex items-center justify-between text-xs font-semibold shadow-sm">
                <div class="flex items-center gap-2">
                    <i class="bi bi-check-circle-fill text-emerald-500 text-sm"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900"><i class="bi bi-x-lg"></i></button>
            </div>
        @endif

        @if(session('error'))
            <div class="mx-4 lg:mx-8 mt-4 p-3.5 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl flex items-center justify-between text-xs font-semibold shadow-sm">
                <div class="flex items-center gap-2">
                    <i class="bi bi-exclamation-octagon-fill text-rose-500 text-sm"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-900"><i class="bi bi-x-lg"></i></button>
            </div>
        @endif

        <!-- Main Body -->
        <main class="flex-1 overflow-y-auto p-4 lg:p-8 custom-scrollbar">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
