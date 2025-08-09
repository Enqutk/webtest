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
        app()["\Spatie\Permission\PermissionRegistrar"]->forgetCachedPermissions();

        $entities = ['blog', 'service', 'team'];
        $actions = ['create', 'read', 'update', 'delete'];
        $roles = ['admin', 'blogger', 'moderator'];

        // Insert permissions
        foreach ($entities as $entity) {
            foreach ($actions as $action) {
                \Spatie\Permission\Models\Permission::create([
                    'name' => "{$action}-{$entity}",
                    'guard_name' => 'web',
                ]);
            }
        }

        // Insert roles
        foreach ($roles as $role) {
            \Spatie\Permission\Models\Role::create([
                'name' => $role,
                'guard_name' => 'web',
            ]);
        }
    }
}
