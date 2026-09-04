<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Models\Organization;
use App\Services\NavbarMenuService;

trait ResolvesSitePageEditorContext
{
    protected function sitePageEditorContext(Organization $org, string $pageKey, array $meta): array
    {
        $data = $org->sitePage($pageKey);
        $liveUrl = route($meta['route'], ['slug' => $org->slug]);
        $previewUrl = $liveUrl . (str_contains($liveUrl, '?') ? '&' : '?') . 'admin_preview=1';

        $navbarMenuService = app(NavbarMenuService::class);
        $headerMenu = $navbarMenuService->resolveMenu($org);
        $navItems = $navbarMenuService->topLevelItems($org);

        return compact('data', 'meta', 'liveUrl', 'previewUrl', 'headerMenu', 'navItems');
    }
}
