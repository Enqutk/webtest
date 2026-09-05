<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ResolvesSitePageEditorContext;
use App\Http\Controllers\Admin\Concerns\SyncsOrganizationContacts;
use App\Http\Controllers\Controller;
use App\Enums\StatusEnum;
use App\Models\Organization;
use App\Models\OrganizationContact;
use App\Models\SocialRef;
use App\Support\ThemeMedia;
use App\Support\UploadedImage;
use Illuminate\Http\Request;

class SitePageController extends Controller
{
    use ResolvesSitePageEditorContext;
    use SyncsOrganizationContacts;

    public const PAGES = [
        'about' => [
            'label' => 'About page',
            'route' => 'card.about',
        ],
        'contact' => [
            'label' => 'Contact page',
            'route' => 'card.contact',
        ],
        'services' => [
            'label' => 'Services page',
            'route' => 'card.services.index',
        ],
        'portfolio' => [
            'label' => 'Portfolio page',
            'route' => 'card.portfolio.index',
        ],
    ];

    public function edit(string $page)
    {
        abort_unless(isset(self::PAGES[$page]), 404);

        if ($page === 'services') {
            return redirect()->route('admin.services.index');
        }

        if ($page === 'portfolio') {
            return redirect()->route('admin.portfolio.index');
        }

        $currentOrg = Organization::resolveCurrent();
        $meta = self::PAGES[$page];
        $context = $this->sitePageEditorContext($currentOrg, $page, $meta);

        $extras = [];
        if ($page === 'contact') {
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
            $extras = compact('contacts', 'socials');
        }

        return view('admin.site-pages.' . $page, array_merge(
            compact('currentOrg', 'page'),
            $context,
            $extras
        ));
    }

    public function update(Request $request, string $page)
    {
        abort_unless(isset(self::PAGES[$page]), 404);

        if ($page === 'about') {
            $request->validate([
                'intro_image' => ['nullable', 'image', 'max:20480'],
                'panel_images.*' => ['nullable', 'image', 'max:20480'],
            ]);
        }

        $currentOrg = Organization::resolveCurrent();
        $theme = is_array($currentOrg->theme) ? $currentOrg->theme : Organization::defaultTheme();
        $existing = $currentOrg->sitePage($page);

        $payload = match ($page) {
            'about' => $this->aboutPayload($request, $existing),
            'contact' => $this->contactPayload($request),
            default => [
                'eyebrow' => $request->input('eyebrow'),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
            ],
        };

        $theme['pages'][$page] = $payload;
        $currentOrg->theme = $theme;
        $currentOrg->save();

        if ($page === 'contact') {
            $this->saveContactDetails($request, $currentOrg);
        }

        return back()->with('success', self::PAGES[$page]['label'] . ' saved. This page only — other pages are unchanged.');
    }

    private function contactPayload(Request $request): array
    {
        return [
            'eyebrow' => $request->input('eyebrow'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'intro' => $request->input('intro'),
        ];
    }

    private function saveContactDetails(Request $request, Organization $currentOrg): void
    {
        $validated = $request->validate([
            'address' => ['nullable', 'string', 'max:500'],
            'contact_emails' => ['nullable', 'array'],
            'contact_emails.*' => ['nullable', 'email', 'max:255'],
            'contact_phones' => ['nullable', 'array'],
            'contact_phones.*' => ['nullable', 'string', 'max:50'],
            'opening_hours' => ['nullable', 'array'],
            'opening_hours.*.days' => ['nullable', 'array'],
            'opening_hours.*.days.*' => ['nullable', 'string', 'max:10'],
            'opening_hours.*.from' => ['nullable', 'string', 'max:10'],
            'opening_hours.*.to' => ['nullable', 'string', 'max:10'],
        ]);

        $openingHours = collect($validated['opening_hours'] ?? [])
            ->map(function ($slot) {
                $days = array_values(array_filter($slot['days'] ?? []));
                $from = $slot['from'] ?? '';
                $to = $slot['to'] ?? '';
                if ($days === [] || $from === '' || $to === '') {
                    return null;
                }

                return [
                    'days' => $days,
                    'from' => strlen($from) === 5 ? $from . ':00' : $from,
                    'to' => strlen($to) === 5 ? $to . ':00' : $to,
                ];
            })
            ->filter()
            ->values()
            ->all();

        $currentOrg->update([
            'address' => $validated['address'] ?? null,
            'opening_hours' => $openingHours,
        ]);

        $this->syncContacts($currentOrg, 'email', $validated['contact_emails'] ?? []);
        $this->syncContacts($currentOrg, 'phone', $validated['contact_phones'] ?? []);
    }

    private function aboutPayload(Request $request, array $existing): array
    {
        $introImage = $existing['intro']['image'] ?? null;
        if ($request->hasFile('intro_image')) {
            $introImage = UploadedImage::storeOptimized($request->file('intro_image'));
        }

        $panels = [];
        foreach ($request->input('panels', []) as $i => $panel) {
            $image = $panel['image'] ?? ($existing['story']['panels'][$i]['image'] ?? null);
            if ($request->hasFile("panel_images.$i")) {
                $image = UploadedImage::storeOptimized($request->file("panel_images.$i"));
            }
            $panels[] = [
                'title' => $panel['title'] ?? '',
                'description' => $panel['description'] ?? '',
                'image' => ThemeMedia::fromUploadState($image),
                'image_focus_x' => (int) ($panel['image_focus_x'] ?? ($existing['story']['panels'][$i]['image_focus_x'] ?? 50)),
                'image_focus_y' => (int) ($panel['image_focus_y'] ?? ($existing['story']['panels'][$i]['image_focus_y'] ?? 50)),
            ];
        }

        $points = collect($request->input('points', []))
            ->map(fn ($point) => [
                'title' => $point['title'] ?? '',
                'icon' => $point['icon'] ?? 'bi bi-check-lg',
                'description' => $point['description'] ?? '',
            ])
            ->values()
            ->all();

        return [
            'eyebrow' => $request->input('eyebrow'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'intro' => [
                'eyebrow' => $request->input('intro_eyebrow'),
                'title' => $request->input('intro_title'),
                'description' => $request->input('intro_description'),
                'image' => $introImage,
                'image_focus_x' => (int) $request->input('intro_image_focus_x', $existing['intro']['image_focus_x'] ?? 50),
                'image_focus_y' => (int) $request->input('intro_image_focus_y', $existing['intro']['image_focus_y'] ?? 50),
                'points' => $points,
            ],
            'story' => [
                'eyebrow' => $request->input('story_eyebrow'),
                'title' => $request->input('story_title'),
                'panels' => $panels,
            ],
            'show_stats' => $request->boolean('show_stats'),
            'show_team' => $request->boolean('show_team'),
            'show_clients' => $request->boolean('show_clients'),
            'show_cta' => $request->boolean('show_cta'),
        ];
    }

}
