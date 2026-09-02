@extends('admin.layouts.app')

@section('title', 'Review Request: ' . $application->name)
@section('header', 'Review Application: ' . $application->name)
@section('subheader', 'Tracking Code: ' . $application->reference_code . ' · Submitted ' . $application->created_at->diffForHumans())

@section('content')
<div class="space-y-6">

    <!-- Top Action & Navigation Bar -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.applications.index') }}" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 transition">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <div class="flex items-center gap-2">
                    <h2 class="text-base font-bold text-slate-900">{{ $application->name }}</h2>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $application->getBadgeClass() }}">
                        {{ ucfirst($application->status) }}
                    </span>
                </div>
                <div class="text-xs text-slate-500 font-mono">{{ $application->reference_code }} · {{ $application->role_title }}</div>
            </div>
        </div>

        <div class="flex items-center gap-2 w-full sm:w-auto">
            @if($application->status !== 'approved')
                <form action="{{ route('admin.applications.approve', $application) }}" method="POST" onsubmit="return confirm('Approve quote and automatically provision the live Organization website /card/{{ $application->slug }}?')">
                    @csrf
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition flex items-center gap-1.5">
                        <i class="bi bi-check2-circle text-sm"></i> Approve Quote & Provision Live Website
                    </button>
                </form>

                <form action="{{ route('admin.applications.reject', $application) }}" method="POST" onsubmit="return confirm('Reject this application?')">
                    @csrf
                    <button type="submit" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-700 font-bold text-xs transition">
                        Reject
                    </button>
                </form>
            @else
                <a href="{{ route('card.home', ['slug' => $application->organization->slug ?? $application->slug]) }}" target="_blank"
                   class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-sm transition flex items-center gap-1.5">
                    <i class="bi bi-box-arrow-up-right"></i> Open Live /card/{{ $application->organization->slug ?? $application->slug }}
                </a>

                <a href="{{ route('admin.home-sections.index', ['org' => $application->organization_id]) }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs transition flex items-center gap-1.5">
                    <i class="bi bi-sliders"></i> Customize in Studio
                </a>
            @endif
        </div>
    </div>

    <!-- Main 2-Column Inspector -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- LEFT: Application Data & Quote Details (7 Cols) -->
        <div class="lg:col-span-7 space-y-6">

            <!-- Card & Quote Summary -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-4">
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Card Package & Quote</h3>
                    <span class="font-mono text-base font-extrabold text-amber-600">{{ $application->quote_amount }}</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Selected Card Finish</span>
                        <div class="font-bold text-slate-900 mt-0.5">{{ $application->getCardEditionTitle() }}</div>
                    </div>
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-100">
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Target Slug</span>
                        <div class="font-mono font-bold text-slate-900 mt-0.5">/card/{{ $application->slug }}</div>
                    </div>
                </div>
            </div>

            <!-- Profile & Bio Details -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-4 text-xs">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Applicant Identity & Story</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Full Name</span>
                        <div class="font-bold text-slate-900 text-sm mt-0.5">{{ $application->name }}</div>
                    </div>
                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Role & Title</span>
                        <div class="font-bold text-slate-900 mt-0.5">{{ $application->role_title }}</div>
                    </div>
                </div>

                @if($application->company_name)
                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Organization / Institution</span>
                        <div class="text-slate-800 mt-0.5 font-medium">{{ $application->company_name }}</div>
                    </div>
                @endif

                @if($application->tagline)
                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Hero Tagline</span>
                        <div class="text-slate-800 mt-0.5">{{ $application->tagline }}</div>
                    </div>
                @endif

                @if($application->bio)
                    <div>
                        <span class="text-slate-400 block text-[10px] uppercase font-bold">About Story / Summary</span>
                        <div class="text-slate-700 mt-1 bg-slate-50 p-3 rounded-xl border border-slate-100 leading-relaxed">{{ $application->bio }}</div>
                    </div>
                @endif
            </div>

            <!-- Highlights & Achievements -->
            @if(!empty($application->highlights))
                <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-3 text-xs">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100 pb-3">Selected Highlights & Projects</h3>
                    <ul class="space-y-2">
                        @foreach($application->highlights as $h)
                            <li class="flex items-center gap-2 p-2 rounded-lg bg-slate-50 text-slate-800 font-medium">
                                <i class="bi bi-check-circle-fill text-emerald-500"></i> {{ $h }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Direct Contact & Social Channels -->
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm space-y-3 text-xs">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100 pb-3">Contact Channels</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="p-3 rounded-xl bg-slate-50">
                        <span class="text-slate-400 block text-[10px]">Email Address</span>
                        <a href="mailto:{{ $application->email }}" class="text-indigo-600 font-bold hover:underline">{{ $application->email }}</a>
                    </div>
                    <div class="p-3 rounded-xl bg-slate-50">
                        <span class="text-slate-400 block text-[10px]">Phone Number</span>
                        <a href="tel:{{ $application->phone }}" class="text-slate-800 font-bold">{{ $application->phone }}</a>
                    </div>
                </div>

                @if(!empty($application->social_links))
                    <div class="pt-2 flex flex-wrap gap-2">
                        @foreach($application->social_links as $network => $link)
                            <span class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 font-medium text-[11px] flex items-center gap-1.5">
                                <i class="bi bi-globe"></i> {{ ucfirst($network) }}: <strong class="text-slate-900">{{ $link }}</strong>
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>

        <!-- RIGHT: Live Outcome Device Inspector (5 Cols) -->
        <div class="lg:col-span-5 space-y-4 lg:sticky lg:top-24">
            
            <div class="bg-slate-900 rounded-3xl p-6 border border-slate-800 text-slate-100 shadow-xl space-y-4">
                
                <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                        <span class="text-xs font-bold text-slate-300 uppercase tracking-wider">Live Outcome Preview</span>
                    </div>
                    <span class="text-[10px] text-slate-500 font-mono">{{ $application->getCardEditionTitle() }}</span>
                </div>

                <!-- Mini Mobile Outcome Simulation -->
                <div class="rounded-2xl p-4 space-y-3 text-center border"
                     style="background-color: {{ $application->theme['bg'] ?? '#0b0f19' }}; border-color: rgba(255,255,255,0.1);">
                    
                    <div class="inline-block px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider bg-white/10"
                         style="color: {{ $application->theme['accent'] ?? '#eab308' }}">
                        {{ $application->role_title }}
                    </div>

                    <!-- Profile Photo / Headshot Shape -->
                    <div class="w-16 h-16 mx-auto overflow-hidden bg-slate-800 border-2 shadow-lg"
                         style="border-color: {{ $application->theme['accent'] ?? '#eab308' }}; border-radius: {{ ($application->theme['image_shape'] ?? 'squircle') === 'circle' ? '9999px' : '28%' }};">
                        @if($application->getFirstMediaUrl('profile_photo'))
                            <img src="{{ $application->getFirstMediaUrl('profile_photo') }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400 font-bold text-base">
                                {{ substr($application->name, 0, 1) }}
                            </div>
                        @endif
                    </div>

                    <h4 class="text-sm font-bold text-white tracking-tight">{{ $application->name }}</h4>
                    <p class="text-[10px] text-slate-400 line-clamp-2">{{ $application->tagline ?: $application->bio }}</p>

                    <div class="pt-1">
                        <span class="px-3 py-1.5 rounded-xl font-bold text-[10px] text-slate-950 inline-block"
                              style="background-color: {{ $application->theme['accent'] ?? '#eab308' }}">
                            Connect with {{ explode(' ', $application->name)[0] }}
                        </span>
                    </div>
                </div>

                <!-- 3D Card Simulation -->
                <div class="p-4 rounded-2xl bg-gradient-to-br from-slate-950 to-slate-900 border border-slate-800 space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <div class="w-8 h-6 rounded bg-gradient-to-br from-yellow-300 to-amber-500 flex items-center justify-center text-[9px] font-bold text-amber-950">NFC</div>
                        <i class="bi bi-wifi text-gold-400 rotate-90 text-sm"></i>
                    </div>
                    <div class="text-xs font-bold text-white tracking-wide uppercase">{{ $application->name }}</div>
                    <div class="text-[10px] text-slate-400">{{ $application->role_title }}</div>
                </div>

                @if($application->status !== 'approved')
                    <form action="{{ route('admin.applications.approve', $application) }}" method="POST" class="pt-2" onsubmit="return confirm('Approve quote and automatically provision the live Organization website /card/{{ $application->slug }}?')">
                        @csrf
                        <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-extrabold text-xs shadow-lg transition flex items-center justify-center gap-1.5">
                            <i class="bi bi-check2-circle text-base"></i> 1-Click Approve & Provision Live Website
                        </button>
                    </form>
                @endif

            </div>

        </div>

    </div>

</div>
@endsection
