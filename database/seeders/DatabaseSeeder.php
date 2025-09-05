<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Directeur aanmaken of ophalen als hij al bestaat
        $user = User::firstOrCreate(
            ['email' => 'directeur@example.com'],
            [
                'name' => 'Directeur',
                'password' => Hash::make('wachtwoord123'),
            ]
        );

        $user->assignRole('directeur');

        // Admin aanmaken of ophalen als hij al bestaat
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('wachtwoord123'),
            ]
        );

        $admin->assignRole('directeur');

        // Call de VisitRequestPermissionSeeder
        $this->call([
            VisitRequestPermissionSeeder::class,
        ]);
    }
}
