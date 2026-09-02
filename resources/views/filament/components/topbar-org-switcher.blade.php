@php
    $orgs = \App\Models\Organization::orderBy('title')->get();
    $activeOrgId = request('org') ?? session('active_organization_id') ?? $orgs->first()?->id;
    $activeOrg = $orgs->firstWhere('id', $activeOrgId) ?? $orgs->first();
    if ($activeOrg && session('active_organization_id') !== $activeOrg->id) {
        session(['active_organization_id' => $activeOrg->id]);
    }
@endphp

@if($orgs->isNotEmpty())
    <div style="display: flex; align-items: center; gap: 0.5rem; padding: 0.35rem 0.75rem; background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 0.5rem; margin-right: 0.75rem;">
        <span style="font-size: 0.75rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 0.25rem;">
            <svg style="width: 1rem; height: 1rem; color: #0284c7;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            Org:
        </span>
        <select onchange="const url = new URL(window.location.href); url.searchParams.set('org', this.value); window.location.href = url.toString();"
            style="font-size: 0.8125rem; font-weight: 700; border-radius: 0.375rem; border: 1px solid #94a3b8; padding: 0.25rem 0.6rem; background: #ffffff; color: #0f172a; cursor: pointer;">
            @foreach($orgs as $org)
                <option value="{{ $org->id }}" {{ $org->id == $activeOrg?->id ? 'selected' : '' }}>
                    {{ $org->title }} ({{ $org->slug }})
                </option>
            @endforeach
        </select>
        <a href="{{ route('card.home', ['slug' => $activeOrg?->slug ?? 'default']) }}" target="_blank"
           style="font-size: 0.75rem; font-weight: 600; color: #0284c7; text-decoration: none; padding: 0.2rem 0.5rem; background: #e0f2fe; border-radius: 0.25rem; display: flex; align-items: center; gap: 0.25rem;">
            <span>Live Site</span>
            <svg style="width: 0.75rem; height: 0.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
        </a>
    </div>
@endif
