<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Admin\Concerns\ResolvesSitePageEditorContext;
use App\Http\Controllers\Admin\Concerns\SavesImageFocus;
use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    use ResolvesSitePageEditorContext;
    use SavesImageFocus;

    public function index()
    {
        $currentOrg = Organization::resolveCurrent();
        $services = Service::query()
            ->where('organization_id', $currentOrg->id)
            ->with('media')
            ->orderBy('order')
            ->paginate(15);

        $meta = SitePageController::PAGES['services'];
        $context = $this->sitePageEditorContext($currentOrg, 'services', $meta);
        $nextOrder = (Service::where('organization_id', $currentOrg->id)->max('order') ?? 0) + 1;

        return view('admin.services.index', array_merge(
            compact('services', 'currentOrg', 'nextOrder'),
            $context
        ));
    }

    public function create()
    {
        $currentOrg = Organization::resolveCurrent();
        return view('admin.services.create', compact('currentOrg'));
    }

    public function store(Request $request)
    {
        $currentOrg = Organization::resolveCurrent();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'quote' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'order' => ['required', 'integer'],
            'status' => ['required', 'in:active,inactive'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['organization_id'] = $currentOrg->id;
        $service = Service::create(array_merge($validated, $this->imageFocusFromRequest($request)));

        if ($request->hasFile('image')) {
            $service->clearMediaCollection('main_image');
            $service->addMediaFromRequest('image')->toMediaCollection('main_image');
        }

        return redirect()->route('admin.services.index')
            ->with('success', "Service '{$service->title}' created successfully!");
    }

    public function quickStore(Request $request)
    {
        $currentOrg = Organization::resolveCurrent();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'quote' => ['nullable', 'string', 'max:500'],
            'order' => ['nullable', 'integer'],
            'status' => ['nullable', 'in:active,inactive'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);

        $validated['organization_id'] = $currentOrg->id;
        $validated['slug'] = Str::slug($validated['title']);
        $validated['order'] = $validated['order'] ?? ((Service::where('organization_id', $currentOrg->id)->max('order') ?? 0) + 1);
        $validated['status'] = $validated['status'] ?? 'active';

        $service = Service::create(array_merge($validated, $this->imageFocusFromRequest($request)));

        if ($request->hasFile('image')) {
            $service->clearMediaCollection('main_image');
            $service->addMediaFromRequest('image')->toMediaCollection('main_image');
        }

        return back()->with('success', "Service '{$service->title}' created!");
    }

    public function edit(Service $service)
    {
        $currentOrg = Organization::resolveCurrent();
        return view('admin.services.edit', compact('service', 'currentOrg'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'quote' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'order' => ['required', 'integer'],
            'status' => ['required', 'in:active,inactive'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);

        $service->update(array_merge($validated, $this->imageFocusFromRequest($request)));

        if ($request->hasFile('image')) {
            $service->clearMediaCollection('main_image');
            $service->addMediaFromRequest('image')->toMediaCollection('main_image');
        }

        return redirect()->route('admin.services.index')
            ->with('success', "Service '{$service->title}' updated successfully!");
    }

    public function quickUpdate(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'quote' => ['nullable', 'string', 'max:500'],
            'order' => ['required', 'integer'],
            'status' => ['required', 'in:active,inactive'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);

        if ($service->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $service->update(array_merge($validated, $this->imageFocusFromRequest($request)));

        if ($request->hasFile('image')) {
            $service->clearMediaCollection('main_image');
            $service->addMediaFromRequest('image')->toMediaCollection('main_image');
        }

        return back()->with('success', "Service '{$service->title}' updated!");
    }

    public function destroy(Service $service)
    {
        $title = $service->title;
        $service->delete();

        return back()->with('success', "Service '{$title}' deleted.");
    }
}
