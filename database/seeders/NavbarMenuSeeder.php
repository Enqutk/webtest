<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use App\Models\MenuLocation;
use App\Services\NavigationService;
use Illuminate\Database\Seeder;

class NavbarMenuSeeder extends Seeder
{
    public function run(): void
    {
        $location = MenuLocation::query()->firstOrCreate(
            ['slug' => 'main-menu'],
            [
                'name' => 'Main Menu',
                'location' => 'navbar',
                'description' => 'Primary public navigation',
            ]
        );

        // Reset items for a clean, production-safe menu
        MenuItem::query()->where('menu_id', $location->id)->forceDelete();

        $home = MenuItem::query()->create([
            'menu_id' => $location->id,
            'parent_id' => null,
            'title' => 'Home',
            'link_type' => 'internal',
            'url' => '/',
            'target' => '_self',
            'order_number' => 1,
        ]);

        MenuItem::query()->create([
            'menu_id' => $location->id,
            'parent_id' => null,
            'title' => 'About',
            'link_type' => 'internal',
            'url' => '/about',
            'target' => '_self',
            'order_number' => 2,
        ]);

        MenuItem::query()->create([
            'menu_id' => $location->id,
            'parent_id' => null,
            'title' => 'Services',
            'link_type' => 'internal',
            'url' => '/our-services',
            'target' => '_self',
            'order_number' => 3,
        ]);

        MenuItem::query()->create([
            'menu_id' => $location->id,
            'parent_id' => null,
            'title' => 'Portfolio',
            'link_type' => 'internal',
            'url' => '/portfolio',
            'target' => '_self',
            'order_number' => 4,
        ]);

        MenuItem::query()->create([
            'menu_id' => $location->id,
            'parent_id' => null,
            'title' => 'Contact',
            'link_type' => 'internal',
            'url' => '/contact',
            'target' => '_self',
            'order_number' => 5,
        ]);

        unset($home);
        app(NavigationService::class)->clearCache();
    }
}
