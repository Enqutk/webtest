<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Models\Organization;
use App\Models\OrganizationContact;
use App\Models\SocialRef;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        $payload = [
            'title' => 'Maji Works',
            'tagline' => 'Climate-smart irrigation, rural WASH, flood resilience, and water-resource GIS across East Africa.',
            'meta_description' => 'Maji Works — climate-smart irrigation, rural WASH, flood resilience, and water-resource GIS.',
            'po_box' => 'P.O. Box 21480',
            'address' => 'Westlands, Nairobi, Kenya',
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
            'map_url' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.817089!2d36.809!3d-1.267!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMcKwMTYnMDEuMiJTIDM2wrA0OCczMi40IkU!5e0!3m2!1sen!2ske!4v1700000000000!5m2!1sen!2ske" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'theme' => Organization::defaultTheme(),
            'status' => 'active',
        ];

        $organization = Organization::query()->first();
        if ($organization) {
            $organization->update($payload);
        } else {
            Organization::query()->create($payload);
        }

        OrganizationContact::query()->delete();
        SocialRef::query()->delete();

        foreach ([
            ['type' => 'email', 'value' => 'hello@majiworks.example'],
            ['type' => 'email', 'value' => 'projects@majiworks.example'],
            ['type' => 'phone', 'value' => '+254 700 441 220'],
            ['type' => 'phone', 'value' => '+254 733 118 904'],
        ] as $contact) {
            OrganizationContact::create(array_merge($contact, ['status' => StatusEnum::active]));
        }

        foreach ([
            ['title' => 'Facebook', 'icon_class' => 'fa-brands fa-facebook-f', 'link' => 'https://www.facebook.com/'],
            ['title' => 'LinkedIn', 'icon_class' => 'fa-brands fa-linkedin-in', 'link' => 'https://www.linkedin.com/'],
            ['title' => 'X', 'icon_class' => 'fa-brands fa-x-twitter', 'link' => 'https://x.com/'],
            ['title' => 'YouTube', 'icon_class' => 'fa-brands fa-youtube', 'link' => 'https://www.youtube.com/'],
        ] as $social) {
            SocialRef::create(array_merge($social, ['status' => StatusEnum::active]));
        }
    }
}
