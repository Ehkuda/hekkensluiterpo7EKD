<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'bewaker',
                'guard_name' => 'web',
            ],
            [
                'name' => 'coordinator',
                'guard_name' => 'web',
            ],
            [
                'name' => 'directeur',
                'guard_name' => 'web',
            ],
        ];

        foreach ($roles as $roleData) {
            Role::updateOrCreate(
                ['name' => $roleData['name'], 'guard_name' => $roleData['guard_name']],
                $roleData
            );
        }
    }
}