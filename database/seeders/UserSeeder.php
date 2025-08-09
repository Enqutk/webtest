<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
  
    public function run(): void
    {
        $admin = \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678'),
        ]);
        $admin->assignRole('admin');

        $moderator = \App\Models\User::create([
            'name' => 'Moderator User',
            'email' => 'moderator@moderator.com',
            'password' => bcrypt('12345678'),
        ]);
        $moderator->assignRole('moderator');

        $blogger = \App\Models\User::create([
            'name' => 'Blogger User',
            'email' => 'blogger@blogger.com',
            'password' => bcrypt('12345678'),
        ]);
        $blogger->assignRole('blogger');
    }
}
