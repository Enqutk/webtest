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
            'map_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4447.059743584574!2d55.236811157874726!3d25.15773988483846!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f69680772d039%3A0x13085a14a32378e7!2sDesert%20Dunes%20building%20contracting%20llc!5e0!3m2!1sen!2set!4v1755167555176!5m2!1sen!2set',
            'status' => 'active',
        ]);

        OrganizationContact::create([
            'type' => 'phone',
            'value' => '+1234567890',
        ]);

        OrganizationContact::create([
            'type' => 'fax',
            'value' => '+1234567891',
        ]);

        OrganizationContact::create([
            'type' => 'email',
            'value' => 'info@demo.org',
        ]);
    }
}
