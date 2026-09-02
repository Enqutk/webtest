@extends('admin.layouts.app')

@section('title', 'Card Requests & Quotes')
@section('header', 'Card Requests & Quotes')
@section('subheader', 'Review incoming NFC card requests, approved quotes, and provision digital websites with 1-click.')

@section('content')
<div class="space-y-6">

    <!-- Top KPI Counter Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-slate-500 font-medium">Pending Review</span>
                <div class="text-2xl font-bold text-amber-600 mt-1">{{ $pendingCount }}</div>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                <i class="bi bi-clock-history"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-slate-500 font-medium">Approved & Live</span>
                <div class="text-2xl font-bold text-emerald-600 mt-1">{{ $approvedCount }}</div>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                <i class="bi bi-check-circle-fill"></i>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm flex items-center justify-between">
            <div>
                <span class="text-xs text-slate-500 font-medium">Public Application Portal</span>
                <div class="text-xs font-bold text-slate-900 mt-1">
                    <a href="{{ route('card.apply') }}" target="_blank" class="text-indigo-600 hover:underline flex items-center gap-1">
                        Open /apply Form <i class="bi bi-box-arrow-up-right text-[10px]"></i>
                    </a>
                </div>
            </div>
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg">
                <i class="bi bi-qr-code-scan"></i>
            </div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.applications.index') }}" class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
            <div class="relative flex-1 sm:w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, code..."
                       class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:ring-1 focus:ring-indigo-500">
                <i class="bi bi-search absolute left-3 top-2.5 text-slate-400 text-xs"></i>
            </div>

            <select name="status" onchange="this.form.submit()" class="px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>

            <button type="submit" class="px-4 py-2 bg-slate-900 text-white rounded-xl text-xs font-medium hover:bg-slate-800 transition">
                Filter
            </button>
            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.applications.index') }}" class="px-3 py-2 text-xs text-slate-500 hover:text-slate-800">Clear</a>
            @endif
        </form>

        <a href="{{ route('card.apply') }}" target="_blank" class="px-4 py-2 bg-gradient-to-r from-amber-500 to-amber-600 text-white rounded-xl text-xs font-bold hover:opacity-90 transition shadow-sm flex items-center gap-1.5 shrink-0">
            <i class="bi bi-plus-lg"></i> Test Public Onboarding Form
        </a>
    </div>

    <!-- Applications Table -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-semibold uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-4">Tracking Code</th>
                        <th class="py-3.5 px-4">Applicant & Role</th>
                        <th class="py-3.5 px-4">Type</th>
                        <th class="py-3.5 px-4">Card Package & Quote</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Date</th>
                        <th class="py-3.5 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($applications as $app)
                        <tr class="hover:bg-slate-50/70 transition">
                            <td class="py-3.5 px-4">
                                <span class="font-mono font-bold text-slate-900 bg-slate-100 px-2 py-0.5 rounded">{{ $app->reference_code }}</span>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900">{{ $app->name }}</div>
                                <div class="text-[11px] text-slate-500">{{ $app->role_title }} {{ $app->company_name ? "· {$app->company_name}" : '' }}</div>
                                <div class="text-[10px] text-slate-400 font-mono">{{ $app->email }} · {{ $app->phone }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $app->type === 'individual' ? 'bg-indigo-50 text-indigo-700' : 'bg-purple-50 text-purple-700' }}">
                                    {{ ucfirst($app->type) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900">{{ $app->quote_amount }}</div>
                                <div class="text-[10px] text-slate-500">{{ $app->getCardEditionTitle() }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $app->getBadgeClass() }}">
                                    {{ ucfirst($app->status) }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-400 text-[11px]">
                                {{ $app->created_at->format('M d, Y') }}
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-1.5">
                                <a href="{{ route('admin.applications.show', $app) }}" class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs inline-flex items-center gap-1 transition">
                                    <i class="bi bi-eye"></i> Inspect & Review
                                </a>

                                @if($app->status === 'approved' && $app->organization)
                                    <a href="{{ route('card.home', ['slug' => $app->organization->slug]) }}" target="_blank" class="px-3 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold text-xs inline-flex items-center gap-1 transition">
                                        <i class="bi bi-globe"></i> Live /card/{{ $app->organization->slug }}
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <i class="bi bi-inbox text-3xl block mb-2 text-slate-300"></i>
                                No card requests found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($applications->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $applications->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
