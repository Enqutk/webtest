<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entities = ['blog', 'service', 'team'];
        $actions = ['create', 'read', 'update', 'delete'];
        $roles = ['admin', 'blogger', 'moderator'];

        // Insert permissions
        foreach ($entities as $entity) {
            foreach ($actions as $action) {
            DB::table('permissions')->insert([
                'name' => "{$action}-{$entity}",
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            }
        }

        // Insert roles
        foreach ($roles as $role) {
            DB::table('roles')->insert([
            'name' => $role,
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
            ]);
        }
    }
}
