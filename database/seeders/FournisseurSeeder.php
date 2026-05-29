<?php

namespace Database\Seeders;

use App\Models\Fournisseur;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class FournisseurSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::first();

        $fournisseurs = [
            [
                'nom'                 => 'BOCOM Distribution',
                'telephone'           => '+237 699 111 222',
                'email'               => 'contact@bocom.cm',
                'adresse'             => 'Douala, Bassa',
                'numero_contribuable' => 'M123456789A',
            ],
            [
                'nom'                 => 'SCDP Cameroun',
                'telephone'           => '+237 677 333 444',
                'email'               => 'info@scdp.cm',
                'adresse'             => 'Yaoundé, Bastos',
                'numero_contribuable' => 'M987654321B',
            ],
            [
                'nom'                 => 'Importateur Global SARL',
                'telephone'           => '+237 655 555 666',
                'email'               => 'global@import.cm',
                'adresse'             => 'Douala, Zone Industrielle',
                'numero_contribuable' => 'M111222333C',
            ],
            [
                'nom'                 => 'Grossiste Alimentaire du Centre',
                'telephone'           => '+237 688 777 888',
                'email'               => null,
                'adresse'             => 'Yaoundé, Mfoundi',
                'numero_contribuable' => null,
            ],
            [
                'nom'                 => 'Pharma Plus Cameroun',
                'telephone'           => '+237 699 999 000',
                'email'               => 'pharmaplus@cm.net',
                'adresse'             => 'Douala, Bonanjo',
                'numero_contribuable' => 'M444555666D',
            ],
        ];

        foreach ($fournisseurs as $data) {
            Fournisseur::firstOrCreate(
                ['nom' => $data['nom'], 'tenant_id' => $tenant->id],
                array_merge($data, ['tenant_id' => $tenant->id])
            );
        }

        $this->command->info('✅ Fournisseurs créés avec succès.');
    }
}
