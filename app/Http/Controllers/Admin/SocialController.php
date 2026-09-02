<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\SocialRef;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function index()
    {
        $currentOrg = Organization::resolveCurrent();
        $socials = SocialRef::query()
            ->where('organization_id', $currentOrg->id)
            ->orderBy('order')
            ->get();

        return view('admin.socials.index', compact('socials', 'currentOrg'));
    }

    public function store(Request $request)
    {
        $currentOrg = Organization::resolveCurrent();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'link' => ['required', 'string', 'max:500'],
            'icon_class' => ['nullable', 'string', 'max:100'],
            'order' => ['nullable', 'integer'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $validated['organization_id'] = $currentOrg->id;
        $validated['order'] = $validated['order'] ?? ((SocialRef::where('organization_id', $currentOrg->id)->max('order') ?? 0) + 1);

        SocialRef::create($validated);

        return back()->with('success', 'Social link added successfully!');
    }

    public function update(Request $request, SocialRef $social)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'link' => ['required', 'string', 'max:500'],
            'icon_class' => ['nullable', 'string', 'max:100'],
            'order' => ['required', 'integer'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        $social->update($validated);

        return back()->with('success', 'Social link updated.');
    }

    public function destroy(SocialRef $social)
    {
        $social->delete();

        return back()->with('success', 'Social link deleted.');
    }
}
