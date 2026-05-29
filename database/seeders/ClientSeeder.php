<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\CategorieClient;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $tenant       = Tenant::first();
        $grossiste    = CategorieClient::where('nom', 'Grossiste')->first();
        $semiGro      = CategorieClient::where('nom', 'Semi-grossiste')->first();
        $detaillant   = CategorieClient::where('nom', 'Détaillant')->first();
        $particulier  = CategorieClient::where('nom', 'Particulier')->first();
        $admin        = CategorieClient::where('nom', 'Administration')->first();

        $clients = [
            [
                'nom'          => 'Supermarché Mahima',
                'categorie_id' => $grossiste->id,
                'telephone'    => '+237 699 100 200',
                'email'        => 'mahima@supermarche.cm',
                'adresse'      => 'Douala, Akwa',
                'solde'        => 0,
            ],
            [
                'nom'          => 'Boutique Centrale Douala',
                'categorie_id' => $semiGro->id,
                'telephone'    => '+237 677 200 300',
                'email'        => null,
                'adresse'      => 'Douala, Deïdo',
                'solde'        => 50000,
            ],
            [
                'nom'          => 'Mini-Market Melen',
                'categorie_id' => $detaillant->id,
                'telephone'    => '+237 655 300 400',
                'email'        => 'melen@minimarket.cm',
                'adresse'      => 'Yaoundé, Melen',
                'solde'        => 0,
            ],
            [
                'nom'          => 'Kiosque Ndokotti',
                'categorie_id' => $detaillant->id,
                'telephone'    => '+237 688 400 500',
                'email'        => null,
                'adresse'      => 'Douala, Ndokotti',
                'solde'        => 15000,
            ],
            [
                'nom'          => 'Martin Dupont',
                'categorie_id' => $particulier->id,
                'telephone'    => '+237 699 500 600',
                'email'        => 'martin@email.com',
                'adresse'      => 'Douala, Bonapriso',
                'solde'        => 0,
            ],
            [
                'nom'          => 'Lycée Bilingue de Douala',
                'categorie_id' => $admin->id,
                'telephone'    => '+237 677 600 700',
                'email'        => 'lbd@education.cm',
                'adresse'      => 'Douala, Koumassi',
                'solde'        => 0,
            ],
            [
                'nom'          => 'Épicerie du Marché',
                'categorie_id' => $detaillant->id,
                'telephone'    => '+237 655 700 800',
                'email'        => null,
                'adresse'      => 'Douala, Marché Central',
                'solde'        => -25000,
            ],
            [
                'nom'          => 'Grossiste de Bassa',
                'categorie_id' => $grossiste->id,
                'telephone'    => '+237 688 800 900',
                'email'        => 'bassa@grossiste.cm',
                'adresse'      => 'Douala, Bassa',
                'solde'        => 100000,
            ],
        ];

        foreach ($clients as $data) {
            Client::firstOrCreate(
                ['nom' => $data['nom'], 'tenant_id' => $tenant->id],
                array_merge($data, ['tenant_id' => $tenant->id])
            );
        }

        $this->command->info('✅ Clients créés avec succès.');
    }
}
