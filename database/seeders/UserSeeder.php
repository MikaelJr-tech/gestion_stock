<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::first();

        // Administrateur
        $admin = User::firstOrCreate(
            ['email' => 'admin@demo.com'],
            [
                'name'      => 'Administrateur',
                'password'  => Hash::make('password'),
                'tenant_id' => $tenant->id,
            ]
        );
        $admin->assignRole('Administrateur');

        // Gestionnaire
        $gestionnaire = User::firstOrCreate(
            ['email' => 'gestionnaire@demo.com'],
            [
                'name'      => 'Jean Gestionnaire',
                'password'  => Hash::make('password'),
                'tenant_id' => $tenant->id,
            ]
        );
        $gestionnaire->assignRole('Gestionnaire');

        // Caissier
        $caissier = User::firstOrCreate(
            ['email' => 'caissier@demo.com'],
            [
                'name'      => 'Marie Caissier',
                'password'  => Hash::make('password'),
                'tenant_id' => $tenant->id,
            ]
        );
        $caissier->assignRole('Caissier');

        // Magasinier
        $magasinier = User::firstOrCreate(
            ['email' => 'magasinier@demo.com'],
            [
                'name'      => 'Paul Magasinier',
                'password'  => Hash::make('password'),
                'tenant_id' => $tenant->id,
            ]
        );
        $magasinier->assignRole('Magasinier');

        $this->command->info('✅ Utilisateurs créés avec succès.');
        $this->command->table(
            ['Nom', 'Email', 'Rôle', 'Mot de passe'],
            [
                ['Administrateur',   'admin@demo.com',        'Administrateur', 'password'],
                ['Jean Gestionnaire','gestionnaire@demo.com', 'Gestionnaire',   'password'],
                ['Marie Caissier',   'caissier@demo.com',     'Caissier',       'password'],
                ['Paul Magasinier',  'magasinier@demo.com',   'Magasinier',     'password'],
            ]
        );
    }
}
