<?php

namespace App\Services;

use App\Enums\MenuLocationEnum;
use App\Models\MenuItem;
use App\Models\MenuLocation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class NavigationService
{
    public function __construct(
        private readonly NavbarMenuService $navbarMenuService,
    ) {}

    public function navbarItems(): Collection
    {
        return $this->itemsForPlacement('header');
    }

    public function footerNavItems(): Collection
    {
        return $this->itemsForPlacement('footer');
    }

    private function itemsForPlacement(string $placement): Collection
    {
        $org = \App\Models\Organization::resolvePublicCurrent();
        $theme = is_array($org?->theme) ? $org->theme : [];

        $showServices = $theme['home_sections']['services']['is_visible'] ?? true;
        $showPortfolio = $theme['home_sections']['portfolio']['is_visible'] ?? true;
        $showAbout = $theme['home_sections']['about']['is_visible'] ?? true;

        if (!$org) {
            return $this->fallbackNavbarRaw();
        }

        $menu = $this->navbarMenuService->resolveMenu($org);

        $dbItems = MenuItem::query()
            ->where('menu_id', $menu->id)
            ->whereNull('parent_id')
            ->when($placement === 'footer', fn ($query) => $query->where('show_in_footer', true))
            ->orderBy('order_number')
            ->with(['children' => fn ($q) => $q->orderBy('order_number')])
            ->get();

        if ($dbItems->isEmpty()) {
            $items = $this->fallbackNavbarRaw();
        } else {
            $items = $dbItems->map(fn (MenuItem $item) => $this->mapItemRaw($item));
        }

        $items = $items->filter(function ($item) use ($showServices, $showPortfolio, $showAbout) {
            $label = strtolower($item['label'] ?? '');
            $url = strtolower($item['url'] ?? '');

            if (!$showServices && (str_contains($label, 'service') || str_contains($url, 'service'))) {
                return false;
            }
            if (!$showPortfolio && (str_contains($label, 'portfolio') || str_contains($label, 'project') || str_contains($url, 'portfolio'))) {
                return false;
            }
            if (!$showAbout && (str_contains($label, 'about') || str_contains($url, '/about'))) {
                return false;
            }

            return true;
        })->values();

        return $items->map(function ($item) {
            $item['active'] = $this->isActive($item['url']);
            if (!empty($item['children'])) {
                $item['children'] = collect($item['children'])->map(function ($child) {
                    $child['active'] = $this->isActive($child['url']);

                    return $child;
                })->all();
            }

            return $item;
        });
    }

    public function clearCache(): void
    {
        Cache::forget('nav.navbar');
        Cache::forget('nav.navbar_raw');
    }

    private function mapItemRaw(MenuItem $item): array
    {
        $url = $this->normalizeUrl((string) $item->url);

        return [
            'label' => $item->title,
            'url' => $url,
            'target' => $item->target ?: '_self',
            'show_in_footer' => (bool) ($item->show_in_footer ?? true),
            'children' => $item->children
                ->map(fn (MenuItem $child) => $this->mapItemRaw($child))
                ->values()
                ->all(),
        ];
    }

    private function normalizeUrl(string $url): string
    {
        $url = trim($url);

        if ($url === '' || $url === '#') {
            return url('/');
        }

        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://') || str_starts_with($url, 'mailto:')) {
            return $url;
        }

        $aliases = [
            '/home' => '/',
            '/service' => '/our-services',
            '/services' => '/our-services',
            '/project' => '/portfolio',
            '/projects' => '/portfolio',
            '/about/history' => '/about',
            '/about/team' => '/about#team',
        ];

        $path = '/' . ltrim(parse_url($url, PHP_URL_PATH) ?: $url, '/');
        $fragment = parse_url($url, PHP_URL_FRAGMENT);
        $mapped = $aliases[$path] ?? $path;

        $org = \App\Models\Organization::resolvePublicCurrent();
        $routeSlug = request()->route('slug') ?? ($org?->slug ?: null);
        if ($routeSlug && !str_starts_with($mapped, "/card/{$routeSlug}")) {
            $mapped = ($mapped === '/') ? "/card/{$routeSlug}" : "/card/{$routeSlug}" . $mapped;
        }

        if ($fragment && !str_contains($mapped, '#')) {
            $mapped .= '#' . $fragment;
        }

        return url($mapped);
    }

    private function isActive(string $url): bool
    {
        $path = rtrim(parse_url($url, PHP_URL_PATH) ?: '/', '/');
        if ($path === '') {
            $path = '/';
        }

        $current = rtrim(request()->getPathInfo() ?: '/', '/');
        if ($current === '') {
            $current = '/';
        }

        if ($current === $path) {
            return true;
        }

        $routeSlug = request()->route('slug');
        if ($path === '/' || ($routeSlug && $path === "/card/{$routeSlug}")) {
            return $current === $path;
        }

        return str_starts_with($current, $path . '/');
    }

    private function fallbackNavbarRaw(): Collection
    {
        return collect([
            ['label' => 'Home', 'url' => url('/'), 'target' => '_self', 'show_in_footer' => true, 'children' => []],
            ['label' => 'About', 'url' => url('/about'), 'target' => '_self', 'show_in_footer' => true, 'children' => []],
            ['label' => 'Services', 'url' => url('/our-services'), 'target' => '_self', 'show_in_footer' => true, 'children' => []],
            ['label' => 'Portfolio', 'url' => url('/portfolio'), 'target' => '_self', 'show_in_footer' => true, 'children' => []],
            ['label' => 'Contact', 'url' => url('/contact'), 'target' => '_self', 'show_in_footer' => true, 'children' => []],
        ]);
    }
}
