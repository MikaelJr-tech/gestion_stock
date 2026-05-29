<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TenantSeeder::class,
            RolePermissionSeeder::class,
            UserSeeder::class,
            FamilleProduitSeeder::class,
            ProduitSeeder::class,
            FournisseurSeeder::class,
            CategorieClientSeeder::class,
            ClientSeeder::class,
            BanqueSeeder::class,
        ]);

        $this->command->info('');
        $this->command->info('🎉 Base de données peuplée avec succès !');
        $this->command->info('');
        $this->command->info('Comptes de connexion :');
        $this->command->info('  admin@demo.com        → password (Administrateur)');
        $this->command->info('  gestionnaire@demo.com → password (Gestionnaire)');
        $this->command->info('  caissier@demo.com     → password (Caissier)');
        $this->command->info('  magasinier@demo.com   → password (Magasinier)');
    }
}
