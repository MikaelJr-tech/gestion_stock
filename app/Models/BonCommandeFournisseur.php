<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BonCommandeFournisseur extends Model
{
    use BelongsToTenant;

    protected $table = 'bons_commande_fournisseur';

    protected $fillable = [
        'tenant_id',
        'fournisseur_id',
        'user_id',
        'numero',
        'date_commande',
        'date_livraison_prevue',
        'statut',
        'montant_total',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'date_commande' => 'date',
            'date_livraison_prevue' => 'date',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function fournisseur(): BelongsTo
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lignes(): HasMany
    {
        return $this->hasMany(LigneCommandeFournisseur::class, 'bon_commande_id');
    }

    public function facture(): HasOne
    {
        return $this->hasOne(FactureFournisseur::class, 'bon_commande_id');
    }
}
