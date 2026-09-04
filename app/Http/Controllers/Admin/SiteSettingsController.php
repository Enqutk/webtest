<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MenuLocationEnum;
use App\Enums\StatusEnum;
use App\Http\Controllers\Admin\Concerns\ResolvesSitePageEditorContext;
use App\Http\Controllers\Controller;
use App\Models\MenuLocation;
use App\Models\Organization;
use App\Models\OrganizationContact;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    use ResolvesSitePageEditorContext;

    public function index()
    {
        $currentOrg = Organization::resolveCurrent();
        $theme = is_array($currentOrg->theme) ? $currentOrg->theme : Organization::defaultTheme();
        $logoUrl = $currentOrg->getFirstMediaUrl('logo');

        $headerMenu = MenuLocation::firstOrCreate(
            [
                'organization_id' => $currentOrg->id,
                'location' => MenuLocationEnum::Navbar,
            ],
            [
                'name' => 'Header Navigation',
                'slug' => 'header-navigation-' . $currentOrg->id,
            ]
        );
        $navItems = $headerMenu->items()->orderBy('order_number')->get();

        $contacts = OrganizationContact::query()
            ->where('organization_id', $currentOrg->id)
            ->where('status', StatusEnum::active)
            ->get()
            ->groupBy('type');

        $meta = ['label' => 'Site Settings'];
        $liveUrl = route('card.home', ['slug' => $currentOrg->slug]);
        $previewUrl = $liveUrl . '?admin_preview=1';

        return view('admin.site-settings.index', compact(
            'currentOrg',
            'theme',
            'logoUrl',
            'headerMenu',
            'navItems',
            'contacts',
            'meta',
            'liveUrl',
            'previewUrl'
        ));
    }

    public function update(Request $request)
    {
        $currentOrg = Organization::resolveCurrent();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:500'],
            'address' => ['nullable', 'string', 'max:500'],
            'po_box' => ['nullable', 'string', 'max:100'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'logo' => ['nullable', 'image', 'max:5120'],
        ]);

        $currentTheme = is_array($currentOrg->theme) ? $currentOrg->theme : Organization::defaultTheme();
        if ($request->has('theme') && is_array($request->theme)) {
            $currentTheme = array_merge($currentTheme, $request->theme);
        }

        $currentOrg->update([
            'title' => $validated['title'],
            'tagline' => $validated['tagline'] ?? null,
            'address' => $validated['address'] ?? null,
            'po_box' => $validated['po_box'] ?? null,
            'theme' => $currentTheme,
        ]);

        if ($request->hasFile('logo')) {
            $currentOrg->clearMediaCollection('logo');
            $currentOrg->addMediaFromRequest('logo')->toMediaCollection('logo');
        }

        $this->syncContact($currentOrg, 'email', $validated['contact_email'] ?? null);
        $this->syncContact($currentOrg, 'phone', $validated['contact_phone'] ?? null);

        $hash = $request->input('_tab', 'header');

        return redirect()
            ->to(route('admin.site-settings.index') . '#' . $hash)
            ->with('success', 'Site settings saved.');
    }

    private function syncContact(Organization $org, string $type, ?string $value): void
    {
        $value = trim((string) $value);

        OrganizationContact::query()
            ->where('organization_id', $org->id)
            ->where('type', $type)
            ->delete();

        if ($value !== '') {
            OrganizationContact::create([
                'organization_id' => $org->id,
                'type' => $type,
                'value' => $value,
                'status' => StatusEnum::active,
            ]);
        }
    }
}
