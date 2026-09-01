<?php

namespace App\Services;

use App\Enums\MenuLocationEnum;
use App\Models\MenuItem;
use App\Models\MenuLocation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class NavigationService
{
    public function navbarItems(): Collection
    {
        $rawItems = Cache::remember('nav.navbar_raw', 3600, function () {
            $org = \App\Models\Organization::first();
            $themeNavItems = $org?->theme['nav_items'] ?? null;

            if (is_array($themeNavItems) && ! empty($themeNavItems)) {
                return collect($themeNavItems)
                    ->filter(fn ($item) => !isset($item['is_visible']) || (bool)$item['is_visible'])
                    ->map(function ($item) {
                        $url = $this->normalizeUrl((string) ($item['url'] ?? '/'));
                        return [
                            'label' => $item['label'] ?? 'Link',
                            'url' => $url,
                            'target' => $item['target'] ?? '_self',
                            'children' => [],
                        ];
                    })
                    ->values();
            }

            $location = MenuLocation::query()
                ->where('location', MenuLocationEnum::Navbar)
                ->first();

            if (! $location) {
                return $this->fallbackNavbarRaw();
            }

            $items = MenuItem::query()
                ->where('menu_id', $location->id)
                ->whereNull('parent_id')
                ->orderBy('order_number')
                ->with(['children' => fn ($q) => $q->orderBy('order_number')])
                ->get();

            if ($items->isEmpty()) {
                return $this->fallbackNavbarRaw();
            }

            return $items->map(fn (MenuItem $item) => $this->mapItemRaw($item));
        });

        // Compute active dynamically per request
        return $rawItems->map(function ($item) {
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

        // Legacy / incorrect seeded paths → real routes
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

        if ($fragment && ! str_contains($mapped, '#')) {
            $mapped .= '#' . $fragment;
        }

        return url($mapped);
    }

    private function isActive(string $url): bool
    {
        $path = parse_url($url, PHP_URL_PATH) ?: '/';
        $current = '/' . ltrim(request()->getPathInfo(), '/');
        if ($current === '//') {
            $current = '/';
        }

        if ($path === '/' || $path === '') {
            return $current === '/';
        }

        return $current === $path || str_starts_with($current, rtrim($path, '/') . '/');
    }

    private function fallbackNavbarRaw(): Collection
    {
        return collect([
            ['label' => 'Home', 'url' => url('/'), 'target' => '_self', 'children' => []],
            ['label' => 'About', 'url' => url('/about'), 'target' => '_self', 'children' => []],
            ['label' => 'Services', 'url' => url('/our-services'), 'target' => '_self', 'children' => []],
            ['label' => 'Portfolio', 'url' => url('/portfolio'), 'target' => '_self', 'children' => []],
            ['label' => 'Contact', 'url' => url('/contact'), 'target' => '_self', 'children' => []],
        ]);
    }

    private function fallbackNavbar(): Collection
    {
        return collect([
            ['label' => 'Home', 'url' => url('/'), 'target' => '_self', 'active' => request()->routeIs('home'), 'children' => []],
            ['label' => 'About', 'url' => url('/about'), 'target' => '_self', 'active' => request()->routeIs('about'), 'children' => []],
            ['label' => 'Services', 'url' => url('/our-services'), 'target' => '_self', 'active' => request()->routeIs('services.*'), 'children' => []],
            ['label' => 'Portfolio', 'url' => url('/portfolio'), 'target' => '_self', 'active' => request()->routeIs('portfolio.*'), 'children' => []],
            ['label' => 'Contact', 'url' => url('/contact'), 'target' => '_self', 'active' => request()->routeIs('contact'), 'children' => []],
        ]);
    }
}
