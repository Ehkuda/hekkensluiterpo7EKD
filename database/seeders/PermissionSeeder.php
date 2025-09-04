<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Array met alle permissions
        $permissions = [
            // Gedetineerden beheer
            ['name' => 'gedetineerden.view', 'description' => 'Gedetineerden bekijken'],
            ['name' => 'gedetineerden.create', 'description' => 'Gedetineerden aanmaken'],
            ['name' => 'gedetineerden.edit', 'description' => 'Gedetineerden bewerken'],
            ['name' => 'gedetineerden.delete', 'description' => 'Gedetineerden verwijderen'],
            ['name' => 'gedetineerden.history', 'description' => 'Gedetineerden geschiedenis bekijken'],
            
            // Cel beheer
            ['name' => 'cellen.view', 'description' => 'Cellen bekijken'],
            ['name' => 'cellen.move', 'description' => 'Gedetineerden verplaatsen tussen cellen'],
            ['name' => 'cellen.history', 'description' => 'Cel geschiedenis bekijken'],
            
            // Bezoekersbeheer
            ['name' => 'visitors.view', 'description' => 'Bezoekers bekijken'],
            ['name' => 'visitors.create', 'description' => 'Bezoekers aanmaken'],
            ['name' => 'visitors.edit', 'description' => 'Bezoekers bewerken'],
            ['name' => 'visitors.delete', 'description' => 'Bezoekers verwijderen'],
            ['name' => 'visits.update', 'description' => 'Bezoek info bijwerken'],
            
            // Gebruikersbeheer (admin)
            ['name' => 'users.view', 'description' => 'Gebruikers bekijken'],
            ['name' => 'users.create', 'description' => 'Gebruikers aanmaken'],
            ['name' => 'users.edit', 'description' => 'Gebruikers bewerken'],
            ['name' => 'users.delete', 'description' => 'Gebruikers verwijderen'],
            
            // Rollenbeheer (admin)
            ['name' => 'roles.view', 'description' => 'Rollen bekijken'],
            ['name' => 'roles.create', 'description' => 'Rollen aanmaken'],
            ['name' => 'roles.edit', 'description' => 'Rollen bewerken'],
            ['name' => 'roles.delete', 'description' => 'Rollen verwijderen'],
            
            // Admin dashboard
            ['name' => 'admin.dashboard', 'description' => 'Admin dashboard toegang'],
            ['name' => 'admin.settings', 'description' => 'Systeem instellingen beheren'],
            
            // Rapportages
            ['name' => 'reports.view', 'description' => 'Rapporten bekijken'],
            ['name' => 'reports.export', 'description' => 'Rapporten exporteren'],
        ];

        // Maak permissions aan
        foreach ($permissions as $permissionData) {
            Permission::firstOrCreate(
                ['name' => $permissionData['name']],
                ['guard_name' => 'web']
            );
        }

        // Wijs permissions toe aan bestaande rollen
        $this->assignPermissionsToRoles();
    }

    private function assignPermissionsToRoles()
    {
        // Directeur krijgt alle permissions
        $directeur = Role::where('name', 'directeur')->first();
        if ($directeur) {
            $directeur->givePermissionTo(Permission::all());
        }

        // Coordinator krijgt permissions voor gedetineerden en cellen beheer
        $coordinator = Role::where('name', 'coordinator')->first();
        if ($coordinator) {
            $coordinatorPermissions = [
                'gedetineerden.view',
                'gedetineerden.create',
                'gedetineerden.edit',
                'gedetineerden.delete',
                'cellen.view',
                'cellen.move',
                'visitors.view',
                'visitors.create',
                'visitors.edit',
                'visits.update',
                'reports.view',
            ];
            $coordinator->givePermissionTo($coordinatorPermissions);
        }

        // Bewaker krijgt basis permissions
        $bewaker = Role::where('name', 'bewaker')->first();
        if ($bewaker) {
            $bewakerPermissions = [
                'gedetineerden.view',
                'cellen.view',
                'visitors.view',
                'visitors.create',
                'visits.update',
            ];
            $bewaker->givePermissionTo($bewakerPermissions);
        }
    }
}