<?php

namespace Database\Seeders;

use App\Enums\StatusEnum;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::query()->value('id');

        $members = [
            [
                'first_name' => 'Amina',
                'last_name' => 'Deng',
                'title' => 'Managing Director',
                'description' => 'Leads strategy and client partnerships across infrastructure programmes.',
                'founder' => true,
                'order' => 1,
            ],
            [
                'first_name' => 'James',
                'last_name' => 'Okello',
                'title' => 'Principal Engineer',
                'description' => 'Specialises in water systems and bulk supply design.',
                'founder' => false,
                'order' => 2,
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Nyibol',
                'title' => 'Project Manager',
                'description' => 'Coordinates delivery, stakeholders, and construction supervision.',
                'founder' => false,
                'order' => 3,
            ],
            [
                'first_name' => 'Daniel',
                'last_name' => 'Kuol',
                'title' => 'Design Lead',
                'description' => 'Guides design quality for civil and sanitation systems.',
                'founder' => false,
                'order' => 4,
            ],
        ];

        foreach ($members as $member) {
            Team::query()->updateOrCreate(
                [
                    'first_name' => $member['first_name'],
                    'last_name' => $member['last_name'],
                ],
                [
                    ...$member,
                    'status' => StatusEnum::active,
                    'created_by' => $userId,
                    'updated_by' => $userId,
                ]
            );
        }
    }
}
