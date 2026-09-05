<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Admin\Concerns\SavesImageFocus;
use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    use SavesImageFocus;

    public function index()
    {
        $currentOrg = Organization::resolveCurrent();
        $members = Team::query()
            ->where('organization_id', $currentOrg->id)
            ->with('media')
            ->orderBy('order')
            ->paginate(20);

        $liveUrl = route('card.home', ['slug' => $currentOrg->slug]) . '#team';
        $previewUrl = route('card.home', ['slug' => $currentOrg->slug, 'admin_preview' => 1]) . '#team';
        $meta = ['label' => 'Team section'];

        return view('admin.team.index', compact('members', 'currentOrg', 'liveUrl', 'previewUrl', 'meta'));
    }

    public function create()
    {
        $currentOrg = Organization::resolveCurrent();
        return view('admin.team.create', compact('currentOrg'));
    }

    public function store(Request $request)
    {
        $currentOrg = Organization::resolveCurrent();

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['nullable', 'string', 'max:120'],
            'title' => ['required', 'string', 'max:190'],
            'description' => ['nullable', 'string', 'max:500'],
            'order' => ['required', 'integer'],
            'status' => ['required', 'in:active,inactive'],
            'founder' => ['nullable', 'boolean'],
            'photo' => ['nullable', 'image', 'max:5120'],
        ]);

        $validated['organization_id'] = $currentOrg->id;
        $validated['founder'] = $request->boolean('founder');
        $validated = array_merge($validated, $this->imageFocusFromRequest($request));

        $member = Team::create($validated);

        if ($request->hasFile('photo')) {
            $member->clearMediaCollection('team-images');
            $member->addMediaFromRequest('photo')->toMediaCollection('team-images');
        }

        return redirect()->route('admin.team.index')
            ->with('success', "Team member '{$member->full_name}' added successfully!");
    }

    public function quickStore(Request $request)
    {
        $currentOrg = Organization::resolveCurrent();

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['nullable', 'string', 'max:120'],
            'title' => ['required', 'string', 'max:190'],
            'description' => ['nullable', 'string', 'max:500'],
            'order' => ['nullable', 'integer'],
            'status' => ['nullable', 'in:active,inactive'],
            'founder' => ['nullable'],
            'photo' => ['nullable', 'image', 'max:5120'],
        ]);

        $validated['organization_id'] = $currentOrg->id;
        $validated['order'] = $validated['order'] ?? ((Team::where('organization_id', $currentOrg->id)->max('order') ?? 0) + 1);
        $validated['status'] = $validated['status'] ?? 'active';
        $validated['founder'] = $request->boolean('founder');
        $validated = array_merge($validated, $this->imageFocusFromRequest($request));

        $member = Team::create($validated);

        if ($request->hasFile('photo')) {
            $member->clearMediaCollection('team-images');
            $member->addMediaFromRequest('photo')->toMediaCollection('team-images');
        }

        return back()->with('success', "Team member '{$member->full_name}' created!");
    }

    public function edit(Team $team)
    {
        $currentOrg = Organization::resolveCurrent();
        return view('admin.team.edit', compact('team', 'currentOrg'));
    }

    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['nullable', 'string', 'max:120'],
            'title' => ['required', 'string', 'max:190'],
            'description' => ['nullable', 'string', 'max:500'],
            'order' => ['required', 'integer'],
            'status' => ['required', 'in:active,inactive'],
            'founder' => ['nullable', 'boolean'],
            'photo' => ['nullable', 'image', 'max:5120'],
        ]);

        $validated['founder'] = $request->boolean('founder');
        $team->update(array_merge($validated, $this->imageFocusFromRequest($request)));

        if ($request->hasFile('photo')) {
            $team->clearMediaCollection('team-images');
            $team->addMediaFromRequest('photo')->toMediaCollection('team-images');
        }

        return redirect()->route('admin.team.index')
            ->with('success', "Team member '{$team->full_name}' updated successfully!");
    }

    public function quickUpdate(Request $request, Team $team)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['nullable', 'string', 'max:120'],
            'title' => ['required', 'string', 'max:190'],
            'description' => ['nullable', 'string', 'max:500'],
            'order' => ['required', 'integer'],
            'status' => ['required', 'in:active,inactive'],
            'founder' => ['nullable'],
            'photo' => ['nullable', 'image', 'max:5120'],
        ]);

        $validated['founder'] = $request->boolean('founder');
        $team->update(array_merge($validated, $this->imageFocusFromRequest($request)));

        if ($request->hasFile('photo')) {
            $team->clearMediaCollection('team-images');
            $team->addMediaFromRequest('photo')->toMediaCollection('team-images');
        }

        return back()->with('success', "Team member '{$team->full_name}' updated!");
    }

    public function destroy(Team $team)
    {
        $name = $team->full_name;
        $team->delete();

        return back()->with('success', "Team member '{$name}' removed.");
    }

    public function toggleStatus(Team $team)
    {
        $team->status = ($team->status === StatusEnum::active) ? StatusEnum::inactive : StatusEnum::active;
        $team->save();

        return back()->with('success', "Status updated for {$team->full_name}.");
    }
}
