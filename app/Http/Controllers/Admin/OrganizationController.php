<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::query()
            ->withCount(['users', 'services', 'teams', 'entities'])
            ->latest()
            ->paginate(12);

        $currentOrg = Organization::resolveCurrent();

        return view('admin.organizations.index', compact('organizations', 'currentOrg'));
    }

    public function create()
    {
        $currentOrg = Organization::resolveCurrent();
        $fontOptions = Organization::getFontOptions();
        $fontWeights = Organization::getFontWeightOptions();
        $shapeOptions = Organization::imageShapeOptions(false);
        $recentInvitations = \App\Models\OrganizationInvitation::latest()->take(10)->get();

        return view('admin.organizations.create', compact('currentOrg', 'fontOptions', 'fontWeights', 'shapeOptions', 'recentInvitations'));
    }

    public function createInvitation(Request $request)
    {
        $validated = $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'client_email' => ['nullable', 'email', 'max:255'],
            'client_phone' => ['nullable', 'string', 'max:50'],
            'initial_role' => ['nullable', 'string', 'max:255'],
            'card_edition' => ['required', 'in:midnight_navy,brushed_gold,executive_black'],
        ]);

        $token = \App\Models\OrganizationInvitation::generateToken();

        $invitation = \App\Models\OrganizationInvitation::create([
            'token' => $token,
            'client_name' => $validated['client_name'],
            'client_email' => $validated['client_email'],
            'client_phone' => $validated['client_phone'],
            'initial_role' => $validated['initial_role'],
            'card_edition' => $validated['card_edition'],
            'created_by' => Auth::id(),
            'status' => 'pending',
            'expires_at' => now()->addDays(14),
        ]);

        return redirect()->route('admin.organizations.create')
            ->with('invitation_created', $invitation);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:100', 'unique:organizations,slug'],
            'domain' => ['nullable', 'string', 'max:255', 'unique:organizations,domain'],
            'tagline' => ['nullable', 'string', 'max:500'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'status' => ['required', 'in:active,inactive'],
            'po_box' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:500'],
            'opening_hours' => ['nullable', 'string'],
            'map_url' => ['nullable', 'string'],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
            $count = Organization::where('slug', $validated['slug'])->count();
            if ($count > 0) {
                $validated['slug'] .= '-' . (Organization::max('id') + 1);
            }
        }

        $theme = Organization::defaultTheme();
        if ($request->has('theme') && is_array($request->theme)) {
            $theme = array_merge($theme, $request->theme);
        }
        $validated['theme'] = $theme;

        $org = Organization::create($validated);

        // Attach creator
        $user = Auth::user();
        if ($user) {
            $org->users()->syncWithoutDetaching([
                $user->id => ['role' => 'owner'],
            ]);
        }

        // Handle Logo upload if present
        if ($request->hasFile('logo')) {
            $org->clearMediaCollection('logo');
            $org->addMediaFromRequest('logo')->toMediaCollection('logo');
        }

        // Handle Favicon upload if present
        if ($request->hasFile('favicon')) {
            $org->clearMediaCollection('favicon');
            $org->addMediaFromRequest('favicon')->toMediaCollection('favicon');
        }

        // Switch to newly created organization
        session(['active_organization_id' => $org->id]);

        return redirect()->route('admin.organizations.edit', $org)
            ->with('success', "Organization '{$org->title}' created successfully!");
    }

    public function edit(Organization $organization)
    {
        $currentOrg = Organization::resolveCurrent();
        $fontOptions = Organization::getFontOptions();
        $fontWeights = Organization::getFontWeightOptions();
        $shapeOptions = Organization::imageShapeOptions(false);
        $members = $organization->users()->withPivot('role')->get();
        $allUsers = User::all();

        return view('admin.organizations.edit', compact('organization', 'currentOrg', 'fontOptions', 'fontWeights', 'shapeOptions', 'members', 'allUsers'));
    }

    public function update(Request $request, Organization $organization)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:100', 'unique:organizations,slug,' . $organization->id],
            'domain' => ['nullable', 'string', 'max:255', 'unique:organizations,domain,' . $organization->id],
            'tagline' => ['nullable', 'string', 'max:500'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'status' => ['required', 'in:active,inactive'],
            'po_box' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:500'],
            'opening_hours' => ['nullable', 'string'],
            'map_url' => ['nullable', 'string'],
        ]);

        $currentTheme = is_array($organization->theme) ? $organization->theme : Organization::defaultTheme();
        if ($request->has('theme') && is_array($request->theme)) {
            $currentTheme = array_merge($currentTheme, $request->theme);
        }
        $validated['theme'] = $currentTheme;

        $organization->update($validated);

        if ($request->hasFile('logo')) {
            $organization->clearMediaCollection('logo');
            $organization->addMediaFromRequest('logo')->toMediaCollection('logo');
        }

        if ($request->hasFile('favicon')) {
            $organization->clearMediaCollection('favicon');
            $organization->addMediaFromRequest('favicon')->toMediaCollection('favicon');
        }

        return back()->with('success', 'Organization settings updated successfully!');
    }

    public function destroy(Organization $organization)
    {
        if (Organization::count() <= 1) {
            return back()->with('error', 'You cannot delete the only existing organization.');
        }

        $title = $organization->title;
        $organization->delete();

        // Switch to first remaining organization
        $first = Organization::first();
        session(['active_organization_id' => $first?->id]);

        return redirect()->route('admin.organizations.index')
            ->with('success', "Organization '{$title}' deleted.");
    }

    public function switchTenant(Organization $organization)
    {
        session(['active_organization_id' => $organization->id]);

        return back()->with('success', "Switched active organization to: {$organization->title}");
    }

    public function addMember(Request $request, Organization $organization)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'role' => ['required', 'in:owner,admin,editor,viewer'],
        ]);

        $organization->users()->syncWithoutDetaching([
            $validated['user_id'] => ['role' => $validated['role']],
        ]);

        return back()->with('success', 'Member added to organization.');
    }

    public function removeMember(Organization $organization, User $user)
    {
        $organization->users()->detach($user->id);

        return back()->with('success', 'Member removed from organization.');
    }
}
