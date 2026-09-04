<?php

namespace App\Services;

use App\Enums\MenuLocationEnum;
use App\Models\MenuItem;
use App\Models\MenuLocation;
use App\Models\Organization;

class NavbarMenuService
{
    public function resolveMenu(Organization $org): MenuLocation
    {
        $menu = MenuLocation::query()
            ->where('organization_id', $org->id)
            ->where('location', MenuLocationEnum::Navbar)
            ->first();

        if ($menu && $menu->items()->whereNull('parent_id')->exists()) {
            return $menu;
        }

        $legacy = MenuLocation::query()
            ->where('location', MenuLocationEnum::Navbar)
            ->where(function ($query) use ($org) {
                $query->whereNull('organization_id')
                    ->orWhere('organization_id', $org->id);
            })
            ->whereHas('items')
            ->orderByRaw('organization_id IS NULL DESC')
            ->first();

        if ($legacy) {
            if ($legacy->organization_id !== $org->id) {
                $legacy->update([
                    'organization_id' => $org->id,
                    'name' => $legacy->name ?: 'Header Navigation',
                    'slug' => 'header-navigation-' . $org->id,
                ]);
            }

            return $legacy->fresh();
        }

        $menu = MenuLocation::firstOrCreate(
            [
                'organization_id' => $org->id,
                'location' => MenuLocationEnum::Navbar,
            ],
            [
                'name' => 'Header Navigation',
                'slug' => 'header-navigation-' . $org->id,
            ]
        );

        if (!$menu->items()->whereNull('parent_id')->exists()) {
            $this->importIntoMenu($org, $menu);
        }

        return $menu->fresh();
    }

    public function topLevelItems(Organization $org)
    {
        $menu = $this->resolveMenu($org);

        return $menu->items()
            ->whereNull('parent_id')
            ->orderBy('order_number')
            ->get();
    }

    public function importIntoMenu(Organization $org, MenuLocation $menu): void
    {
        if ($menu->items()->whereNull('parent_id')->exists()) {
            return;
        }

        $theme = is_array($org->theme) ? $org->theme : Organization::defaultTheme();
        $sources = collect($theme['nav_items'] ?? [])
            ->when(
                empty($theme['nav_items']),
                fn ($c) => collect(Organization::defaultNavItems())
            );

        foreach ($sources->values() as $index => $item) {
            if (isset($item['is_visible']) && !$item['is_visible']) {
                continue;
            }

            MenuItem::create([
                'menu_id' => $menu->id,
                'parent_id' => null,
                'title' => $item['label'] ?? $item['title'] ?? 'Link',
                'link_type' => 'internal',
                'url' => $item['url'] ?? '/',
                'target' => $item['target'] ?? '_self',
                'order_number' => $index + 1,
                'show_in_footer' => (bool) ($item['show_in_footer'] ?? true),
            ]);
        }

        $this->clearThemeNavItems($org);
    }

    public function clearThemeNavItems(Organization $org): void
    {
        $theme = is_array($org->theme) ? $org->theme : Organization::defaultTheme();
        if (!array_key_exists('nav_items', $theme)) {
            return;
        }

        unset($theme['nav_items']);
        $org->theme = $theme;
        $org->save();
    }
}
