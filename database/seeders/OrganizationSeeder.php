<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Organization::create([
            'title' => 'Demo Organization',
            'po_box' => 'PO Box 12345',
            'address' => '123 Demo Street, Demo City, Country',
            'opening_hours' => 'Mon-Fri: 9am-5pm',
            'map_url' => 'https://maps.example.com/demo-org',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
