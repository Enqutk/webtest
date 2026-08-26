<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            UserSeeder::class,
            OrganizationSeeder::class,
            MenuSeeder::class,
            PageSeeder::class,
            ServiceSeeder::class,
            HeroSeeder::class,
            TeamSeeder::class,
            EntitySeeder::class,
            StatsSeeder::class,
        ]);
    }
}
