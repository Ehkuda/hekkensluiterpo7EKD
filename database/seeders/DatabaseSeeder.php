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
        // Maak een Directeur aan
        $user = User::create([
            'name' => 'Directeur',
            'email' => 'directeur@example.com',
            'password' => Hash::make('wachtwoord123'), // Gebruik bcrypt
        ]);

        // Wijs de 'directeur' rol toe aan de gebruiker
        $user->assignRole('directeur');

        // Maak een Admin aan, die ook dezelfde rechten heeft als de Directeur
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('wachtwoord123'), // Gebruik bcrypt
        ]);
    }
}
