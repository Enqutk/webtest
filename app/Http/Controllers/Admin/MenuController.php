<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\MenuLocation;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function index()
    {
        $currentOrg = Organization::resolveCurrent();
        $menus = MenuLocation::query()
            ->where('organization_id', $currentOrg->id)
            ->with(['items' => function ($q) {
                $q->orderBy('order_number');
            }])
            ->get();

        return view('admin.menus.index', compact('menus', 'currentOrg'));
    }

    public function storeMenu(Request $request)
    {
        $currentOrg = Organization::resolveCurrent();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $validated['organization_id'] = $currentOrg->id;
        $validated['slug'] = Str::slug($validated['name']);

        $menu = MenuLocation::create($validated);

        return back()->with('success', "Menu '{$menu->name}' created.");
    }

    public function storeItem(Request $request)
    {
        $validated = $request->validate([
            'menu_id' => ['required', 'exists:menu_locations,id'],
            'title' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:255'],
            'order_number' => ['nullable', 'integer'],
            'target' => ['nullable', 'string', 'in:_self,_blank'],
            'icon' => ['nullable', 'string', 'max:100'],
        ]);

        $validated['order_number'] = $validated['order_number'] ?? ((MenuItem::where('menu_id', $validated['menu_id'])->max('order_number') ?? 0) + 1);

        MenuItem::create($validated);

        return back()->with('success', 'Menu link added successfully!');
    }

    public function updateItem(Request $request, MenuItem $item)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:255'],
            'order_number' => ['required', 'integer'],
            'target' => ['nullable', 'string', 'in:_self,_blank'],
            'icon' => ['nullable', 'string', 'max:100'],
        ]);

        $item->update($validated);

        return back()->with('success', 'Menu link updated.');
    }

    public function destroyItem(MenuItem $item)
    {
        $item->delete();

        return back()->with('success', 'Menu link removed.');
    }

    public function destroyMenu(MenuLocation $menu)
    {
        $menu->items()->delete();
        $menu->delete();

        return back()->with('success', 'Menu deleted.');
    }
}
