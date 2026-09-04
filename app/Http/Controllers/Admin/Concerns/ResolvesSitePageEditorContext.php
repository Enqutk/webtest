<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Enums\MenuLocationEnum;
use App\Models\MenuLocation;
use App\Models\Organization;

trait ResolvesSitePageEditorContext
{
    protected function sitePageEditorContext(Organization $org, string $pageKey, array $meta): array
    {
        $data = $org->sitePage($pageKey);
        $liveUrl = route($meta['route'], ['slug' => $org->slug]);
        $previewUrl = $liveUrl . (str_contains($liveUrl, '?') ? '&' : '?') . 'admin_preview=1';
        $headerMenu = MenuLocation::firstOrCreate(
            [
                'organization_id' => $org->id,
                'location' => MenuLocationEnum::Navbar,
            ],
            [
                'name' => 'Header Navigation',
                'slug' => 'header-navigation-' . $org->id,
            ]
        );
        $navItems = $headerMenu->items()->orderBy('order_number')->get();

        return compact('data', 'meta', 'liveUrl', 'previewUrl', 'headerMenu', 'navItems');
    }
}
