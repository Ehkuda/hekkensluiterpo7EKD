<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Maak permissions aan per categorie
        $permissions = [
            // Gedetineerden beheer
            'gedetineerden' => [
                'gedetineerden.view' => 'Gedetineerden bekijken',
                'gedetineerden.create' => 'Gedetineerden aanmaken',
                'gedetineerden.edit' => 'Gedetineerden bewerken',
                'gedetineerden.delete' => 'Gedetineerden verwijderen',
                'gedetineerden.history' => 'Gedetineerden geschiedenis bekijken',
            ],
            
            // Cellen beheer
            'cellen' => [
                'cellen.view' => 'Cellen bekijken',
                'cellen.move' => 'Gedetineerden verplaatsen',
                'cellen.history' => 'Cel geschiedenis bekijken',
            ],
            
            // Rapportage
            'rapportage' => [
                'rapportage.view' => 'Rapporten bekijken',
                'rapportage.export' => 'Rapporten exporteren',
                'rapportage.advanced' => 'Geavanceerde rapporten',
            ],
            
            // Gebruikersbeheer
            'gebruikers' => [
                'gebruikers.view' => 'Gebruikers bekijken',
                'gebruikers.create' => 'Gebruikers aanmaken',
                'gebruikers.edit' => 'Gebruikers bewerken',
                'gebruikers.delete' => 'Gebruikers verwijderen',
            ],
            
            // Rollenbeheer
            'rollen' => [
                'rollen.view' => 'Rollen bekijken',
                'rollen.create' => 'Rollen aanmaken',
                'rollen.edit' => 'Rollen bewerken',
                'rollen.delete' => 'Rollen verwijderen',
            ],
            
            // Systeem beheer
            'systeem' => [
                'systeem.settings' => 'Systeem instellingen',
                'systeem.backup' => 'Backup beheer',
                'systeem.logs' => 'Logbestanden bekijken',
            ],
            
            // Dashboard
            'dashboard' => [
                'dashboard.view' => 'Dashboard bekijken',
                'dashboard.stats' => 'Statistieken bekijken',
            ]
        ];

        // Maak alle permissions aan
        foreach ($permissions as $category => $categoryPermissions) {
            foreach ($categoryPermissions as $permission => $description) {
                Permission::updateOrCreate([
                    'name' => $permission,
                    'guard_name' => 'web'
                ], [
                    'category' => $category,
                    'description' => $description
                ]);
            }
        }

        // Wijs permissions toe aan rollen
        $this->assignPermissionsToRoles();
    }

    private function assignPermissionsToRoles()
    {
        // Bewaker - alleen lezen
        $bewaker = Role::findByName('bewaker');
        $bewaker->givePermissionTo([
            'dashboard.view',
            'dashboard.stats',
            'gedetineerden.view',
            'cellen.view',
            'rapportage.view',
        ]);

        // Coordinator - lezen en schrijven
        $coordinator = Role::findByName('coordinator');
        $coordinator->givePermissionTo([
            'dashboard.view',
            'dashboard.stats',
            'gedetineerden.view',
            'gedetineerden.create',
            'gedetineerden.edit',
            'gedetineerden.delete',
            'cellen.view',
            'cellen.move',
            'rapportage.view',
            'rapportage.export',
        ]);

        // Directeur - alle rechten
        $directeur = Role::findByName('directeur');
        $directeur->givePermissionTo(Permission::all());
    }
}