<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EntityTypeEnum;
use App\Enums\StatusEnum;
use App\Http\Controllers\Admin\Concerns\ResolvesSitePageEditorContext;
use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Models\Organization;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    use ResolvesSitePageEditorContext;

    public function index()
    {
        $currentOrg = Organization::resolveCurrent();
        $projects = Entity::query()
            ->where('organization_id', $currentOrg->id)
            ->where('type', EntityTypeEnum::project)
            ->with('media')
            ->orderBy('order')
            ->paginate(15);

        $meta = SitePageController::PAGES['portfolio'];
        $context = $this->sitePageEditorContext($currentOrg, 'portfolio', $meta);
        $nextOrder = (Entity::where('organization_id', $currentOrg->id)->where('type', EntityTypeEnum::project)->max('order') ?? 0) + 1;

        return view('admin.portfolio.index', array_merge(
            compact('projects', 'currentOrg', 'nextOrder'),
            $context
        ));
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

    public function quickStore(Request $request)
    {
        $currentOrg = Organization::resolveCurrent();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'link' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'order' => ['nullable', 'integer'],
            'status' => ['nullable', 'in:active,inactive'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);

        $validated['organization_id'] = $currentOrg->id;
        $validated['type'] = EntityTypeEnum::project;
        $validated['order'] = $validated['order'] ?? ((Entity::where('organization_id', $currentOrg->id)->where('type', EntityTypeEnum::project)->max('order') ?? 0) + 1);
        $validated['status'] = $validated['status'] ?? 'active';

        $project = Entity::create($validated);

        if ($request->hasFile('image')) {
            $project->clearMediaCollection('image');
            $project->addMediaFromRequest('image')->toMediaCollection('image');
        }

        return back()->with('success', "Project '{$project->name}' created!");
    }

    public function quickUpdate(Request $request, Entity $portfolio)
    {
        abort_unless($portfolio->type === EntityTypeEnum::project, 404);

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

        return back()->with('success', "Project '{$portfolio->name}' updated!");
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
