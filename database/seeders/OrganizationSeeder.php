<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\OrganizationContact;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
  
    public function run(): void
    {
        $organization = Organization::create([
            'title' => 'Demo Organization',
            'po_box' => 'PO Box 12345',
            'address' => '123 Demo Street, Demo City, Country',
            'opening_hours' => [
                [
                    'days' => ['mon', 'tue', 'wed', 'thu', 'fri'],
                    'from' => '09:00:00',
                    'to' => '17:00:00',
                ],
            ],
            'map_url' => 'https://maps.example.com/demo-org',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        OrganizationContact::create([
            'organization_id' => $organization->id,
            'type' => 'phone',
            'value' => '+1234567890',
        ]);

        OrganizationContact::create([
            'organization_id' => $organization->id,
            'type' => 'fax',
            'value' => '+1234567891',
        ]);

        OrganizationContact::create([
            'organization_id' => $organization->id,
            'type' => 'email',
            'value' => 'info@demo.org',
        ]);
    }
}
