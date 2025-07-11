<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Maak of update de Directeur-gebruiker
        $directeur = User::updateOrCreate(
            ['email' => 'directeur@example.com'],
            [
                'name' => 'Directeur',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $directeur->assignRole('directeur');

        // Maak of update de Admin-gebruiker
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('directeur'); // Admin krijgt directeur-rol, gebaseerd op activity_logs

        // Maak of update de Bewaker-gebruiker
        $bewaker = User::updateOrCreate(
            ['email' => 'bewaker@example.com'],
            [
                'name' => 'Bewaker',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );
        $bewaker->assignRole('bewaker');
    }
}