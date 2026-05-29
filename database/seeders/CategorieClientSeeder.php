<?php

namespace Database\Seeders;

use App\Models\CategorieClient;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class CategorieClientSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::first();

        $categories = [
            [
                'nom'            => 'Grossiste',
                'remise_default' => 10,
            ],
            [
                'nom'            => 'Semi-grossiste',
                'remise_default' => 5,
            ],
            [
                'nom'            => 'Détaillant',
                'remise_default' => 2,
            ],
            [
                'nom'            => 'Particulier',
                'remise_default' => 0,
            ],
            [
                'nom'            => 'Administration',
                'remise_default' => 8,
            ],
        ];

        foreach ($categories as $data) {
            CategorieClient::firstOrCreate(
                ['nom' => $data['nom'], 'tenant_id' => $tenant->id],
                array_merge($data, ['tenant_id' => $tenant->id])
            );
        }

        $this->command->info('✅ Catégories clients créées avec succès.');
    }
}
