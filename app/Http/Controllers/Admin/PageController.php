<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $currentOrg = Organization::resolveCurrent();
        $pages = Page::query()
            ->where('organization_id', $currentOrg->id)
            ->whereNotIn('slug', Page::RESERVED_SLUGS)
            ->with(['media', 'sections'])
            ->orderBy('display_order')
            ->paginate(15);

        return view('admin.pages.index', compact('pages', 'currentOrg'));
    }

    public function store(Request $request)
    {
        $currentOrg = Organization::resolveCurrent();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'display_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
            'hero_image' => ['nullable', 'image', 'max:5120'],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if (in_array($validated['slug'], Page::RESERVED_SLUGS, true)) {
            return back()
                ->withInput()
                ->with('error', 'That slug is reserved for a built-in page. Use the dedicated page editors instead.');
        }

        $validated['organization_id'] = $currentOrg->id;
        $validated['display_order'] = $validated['display_order'] ?? ((Page::where('organization_id', $currentOrg->id)->max('display_order') ?? 0) + 1);
        $validated['is_active'] = $request->boolean('is_active');

        $page = Page::create($validated);

        if ($request->hasFile('hero_image')) {
            $page->clearMediaCollection('hero_image');
            $page->addMediaFromRequest('hero_image')->toMediaCollection('hero_image');
        }

        return redirect()->route('admin.pages.index')
            ->with('success', "Page '{$page->title}' created successfully!");
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'display_order' => ['required', 'integer'],
            'is_active' => ['nullable', 'boolean'],
            'hero_image' => ['nullable', 'image', 'max:5120'],
        ]);

        if (in_array($validated['slug'], Page::RESERVED_SLUGS, true)) {
            return back()
                ->withInput()
                ->with('error', 'That slug is reserved for a built-in page. Use the dedicated page editors instead.');
        }

        $validated['is_active'] = $request->boolean('is_active');
        $page->update($validated);

        if ($request->hasFile('hero_image')) {
            $page->clearMediaCollection('hero_image');
            $page->addMediaFromRequest('hero_image')->toMediaCollection('hero_image');
        }

        return redirect()->route('admin.pages.index')
            ->with('success', "Page '{$page->title}' updated successfully!");
    }

    public function destroy(Page $page)
    {
        $title = $page->title;
        $page->delete();

        return back()->with('success', "Page '{$title}' deleted.");
    }
}
