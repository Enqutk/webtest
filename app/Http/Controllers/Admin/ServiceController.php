<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $currentOrg = Organization::resolveCurrent();
        $services = Service::query()
            ->where('organization_id', $currentOrg->id)
            ->with('media')
            ->orderBy('order')
            ->paginate(15);

        return view('admin.services.index', compact('services', 'currentOrg'));
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
        $service = Service::create($validated);

        if ($request->hasFile('image')) {
            $service->clearMediaCollection('service-images');
            $service->addMediaFromRequest('image')->toMediaCollection('service-images');
        }

        return redirect()->route('admin.services.index')
            ->with('success', "Service '{$service->title}' created successfully!");
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

        $service->update($validated);

        if ($request->hasFile('image')) {
            $service->clearMediaCollection('service-images');
            $service->addMediaFromRequest('image')->toMediaCollection('service-images');
        }

        return redirect()->route('admin.services.index')
            ->with('success', "Service '{$service->title}' updated successfully!");
    }

    public function destroy(Service $service)
    {
        $title = $service->title;
        $service->delete();

        return back()->with('success', "Service '{$title}' deleted.");
    }
}
