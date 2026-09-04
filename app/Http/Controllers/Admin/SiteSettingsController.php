<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Admin\Concerns\ResolvesSitePageEditorContext;
use App\Http\Controllers\Admin\Concerns\SyncsOrganizationContacts;
use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\OrganizationContact;
use App\Models\SocialRef;
use App\Services\NavbarMenuService;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    use ResolvesSitePageEditorContext;
    use SyncsOrganizationContacts;

    public function __construct(
        private readonly NavbarMenuService $navbarMenuService,
    ) {}

    public function index()
    {
        $currentOrg = Organization::resolveCurrent();
        $theme = is_array($currentOrg->theme) ? $currentOrg->theme : Organization::defaultTheme();
        $logoUrl = $currentOrg->getFirstMediaUrl('logo');

        $headerMenu = $this->navbarMenuService->resolveMenu($currentOrg);
        $navItems = $this->navbarMenuService->topLevelItems($currentOrg);

        $contacts = OrganizationContact::query()
            ->where('organization_id', $currentOrg->id)
            ->where('status', StatusEnum::active)
            ->orderBy('id')
            ->get()
            ->groupBy('type');

        $socials = SocialRef::query()
            ->where('organization_id', $currentOrg->id)
            ->orderBy('order')
            ->get();

        $connectLinks = $theme['footer_connect_links'] ?? [
            ['label' => 'Contact', 'url' => '/contact'],
        ];

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
            'socials',
            'connectLinks',
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
            'contact_emails' => ['nullable', 'array'],
            'contact_emails.*' => ['nullable', 'email', 'max:255'],
            'contact_phones' => ['nullable', 'array'],
            'contact_phones.*' => ['nullable', 'string', 'max:50'],
            'connect_links' => ['nullable', 'array'],
            'connect_links.*.label' => ['nullable', 'string', 'max:100'],
            'connect_links.*.url' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:5120'],
        ]);

        $currentTheme = is_array($currentOrg->theme) ? $currentOrg->theme : Organization::defaultTheme();
        if ($request->has('theme') && is_array($request->theme)) {
            $currentTheme = array_merge($currentTheme, $request->theme);
        }

        $connectLinks = collect($validated['connect_links'] ?? [])
            ->map(fn ($link) => [
                'label' => trim($link['label'] ?? ''),
                'url' => trim($link['url'] ?? ''),
            ])
            ->filter(fn ($link) => $link['label'] !== '' && $link['url'] !== '')
            ->values()
            ->all();

        if ($connectLinks !== []) {
            $currentTheme['footer_connect_links'] = $connectLinks;
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

        $this->syncContacts($currentOrg, 'email', $validated['contact_emails'] ?? []);
        $this->syncContacts($currentOrg, 'phone', $validated['contact_phones'] ?? []);

        $hash = preg_replace('/[^a-z0-9\-]/', '', (string) $request->input('_hash', 'header')) ?: 'header';

        return redirect()
            ->to(route('admin.site-settings.index') . '#' . $hash)
            ->with('success', 'Site settings saved.');
    }
}
