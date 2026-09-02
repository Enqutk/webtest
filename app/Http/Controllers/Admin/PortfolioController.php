<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EntityTypeEnum;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Models\Organization;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index()
    {
        $currentOrg = Organization::resolveCurrent();
        $projects = Entity::query()
            ->where('organization_id', $currentOrg->id)
            ->where('type', EntityTypeEnum::project)
            ->with('media')
            ->orderBy('order')
            ->paginate(15);

        return view('admin.portfolio.index', compact('projects', 'currentOrg'));
    }

    public function create()
    {
        $currentOrg = Organization::resolveCurrent();
        return view('admin.portfolio.create', compact('currentOrg'));
    }

    public function store(Request $request)
    {
        $currentOrg = Organization::resolveCurrent();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'link' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'order' => ['required', 'integer'],
            'status' => ['required', 'in:active,inactive'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);

        $validated['organization_id'] = $currentOrg->id;
        $validated['type'] = EntityTypeEnum::project;

        $project = Entity::create($validated);

        if ($request->hasFile('image')) {
            $project->clearMediaCollection('image');
            $project->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return redirect()->route('admin.portfolio.index')
            ->with('success', "Project '{$project->name}' created successfully!");
    }

    public function edit(Entity $portfolio)
    {
        $currentOrg = Organization::resolveCurrent();
        return view('admin.portfolio.edit', compact('portfolio', 'currentOrg'));
    }

    public function update(Request $request, Entity $portfolio)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'link' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'order' => ['required', 'integer'],
            'status' => ['required', 'in:active,inactive'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);

        $portfolio->update($validated);

        if ($request->hasFile('image')) {
            $portfolio->clearMediaCollection('image');
            $portfolio->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return redirect()->route('admin.portfolio.index')
            ->with('success', "Project '{$portfolio->name}' updated successfully!");
    }

    public function destroy(Entity $portfolio)
    {
        $name = $portfolio->name;
        $portfolio->delete();

        return back()->with('success', "Project '{$name}' deleted.");
    }
}
