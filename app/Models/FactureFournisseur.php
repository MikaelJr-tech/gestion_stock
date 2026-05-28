<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FactureFournisseur extends Model
{
    use BelongsToTenant;

    protected $table = 'factures_fournisseur';

    protected $fillable = [
        'tenant_id',
        'bon_commande_id',
        'fournisseur_id',
        'user_id',
        'numero',
        'date_facture',
        'date_echeance',
        'montant_ht',
        'tva',
        'montant_ttc',
        'montant_regle',
        'statut',
    ];

    protected function casts(): array
    {
        return [
            'date_facture' => 'date',
            'date_echeance' => 'date',
            'montant_ht' => 'decimal:2',
            'montant_ttc' => 'decimal:2',
            'montant_regle' => 'decimal:2',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function bonCommande(): BelongsTo
    {
        return $this->belongsTo(BonCommandeFournisseur::class, 'bon_commande_id');
    }

    public function fournisseur(): BelongsTo
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function resteAPayer(): float
    {
        return $this->montant_ttc - $this->montant_regle;
    }
}
