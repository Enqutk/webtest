<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\OrganizationContact;
use App\Enums\StatusEnum;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
  
    public function run(): void
    {
        $organization = Organization::create([
            'title' => 'Veritas Afrika',
            'po_box' => '',
            'address' => 'Hia cinema, JubaSouth Sudan',
            'opening_hours' => [
                [
                    'days' => ['mon', 'tue', 'wed', 'thu', 'fri'],
                    'from' => '08:00:00',
                    'to' => '17:00:00',
                ],
                [
                    'days' => ['sat'],
                    'from' => '09:00:00',
                    'to' => '13:00:00',
                ],
            ],
            'map_url' => '',
            'status' => 'active',
        ]);

        OrganizationContact::create([
            'type' => 'phone',
            'value' => '+211 923 2 41 605',
            'status' => StatusEnum::active,
        ]);

        OrganizationContact::create([
            'type' => 'phone',
            'value' => '+27 749 505 555',
            'status' => StatusEnum::active,
        ]);

        OrganizationContact::create([
            'type' => 'email',
            'value' => 'contact@veritasafrika.com',
            'status' => StatusEnum::active,
        ]);

        OrganizationContact::create([
            'type' => 'email',
            'value' => 'info@veritasafrika.com',
            'status' => StatusEnum::active,
        ]);
    }
}
