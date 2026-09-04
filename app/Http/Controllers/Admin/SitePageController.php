<?php

namespace App\Http\Controllers\Admin;

use App\Enums\MenuLocationEnum;
use App\Http\Controllers\Controller;
use App\Models\MenuLocation;
use App\Models\Organization;
use App\Support\ThemeMedia;
use Illuminate\Http\Request;

class SitePageController extends Controller
{
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

        $currentOrg = Organization::resolveCurrent();
        $data = $currentOrg->sitePage($page);
        $meta = self::PAGES[$page];
        $liveUrl = route($meta['route'], ['slug' => $currentOrg->slug]);
        $previewUrl = $liveUrl . (str_contains($liveUrl, '?') ? '&' : '?') . 'admin_preview=1';
        $headerMenu = $this->headerMenuFor($currentOrg);
        $navItems = $headerMenu->items()->orderBy('order_number')->get();

        return view('admin.site-pages.' . $page, compact('currentOrg', 'data', 'page', 'meta', 'liveUrl', 'previewUrl', 'headerMenu', 'navItems'));
    }

    public function update(Request $request, string $page)
    {
        abort_unless(isset(self::PAGES[$page]), 404);

        $currentOrg = Organization::resolveCurrent();
        $theme = is_array($currentOrg->theme) ? $currentOrg->theme : Organization::defaultTheme();
        $existing = $currentOrg->sitePage($page);

        $payload = match ($page) {
            'about' => $this->aboutPayload($request, $existing),
            'contact' => [
                'eyebrow' => $request->input('eyebrow'),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'intro' => $request->input('intro'),
            ],
            default => [
                'eyebrow' => $request->input('eyebrow'),
                'title' => $request->input('title'),
                'description' => $request->input('description'),
            ],
        };

        $theme['pages'][$page] = $payload;
        $currentOrg->theme = $theme;
        $currentOrg->save();

        return back()->with('success', self::PAGES[$page]['label'] . ' saved. This page only — other pages are unchanged.');
    }

    private function aboutPayload(Request $request, array $existing): array
    {
        $introImage = $existing['intro']['image'] ?? null;
        if ($request->hasFile('intro_image')) {
            $introImage = $request->file('intro_image')->store('page-images', 'public');
        }

        $panels = [];
        foreach ($request->input('panels', []) as $i => $panel) {
            $image = $panel['image'] ?? ($existing['story']['panels'][$i]['image'] ?? null);
            if ($request->hasFile("panel_images.$i")) {
                $image = $request->file("panel_images.$i")->store('page-images', 'public');
            }
            $panels[] = [
                'title' => $panel['title'] ?? '',
                'description' => $panel['description'] ?? '',
                'image' => ThemeMedia::fromUploadState($image),
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

    private function headerMenuFor(Organization $org): MenuLocation
    {
        return MenuLocation::firstOrCreate(
            [
                'organization_id' => $org->id,
                'location' => MenuLocationEnum::Navbar,
            ],
            [
                'name' => 'Header Navigation',
                'slug' => 'header-navigation-' . $org->id,
            ]
        );
    }
}
