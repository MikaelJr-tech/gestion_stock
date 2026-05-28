<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produit extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'famille_id',
        'produit_parent_id',
        'code',
        'nom',
        'unite',
        'prix_achat',
        'prix_vente',
        'stock_actuel',
        'stock_minimum',
        'date_expiration',
        'type',
        'facteur_fraction',
    ];

    protected function casts(): array
    {
        return [
            'date_expiration' => 'date',
            'prix_achat' => 'decimal:2',
            'prix_vente' => 'decimal:2',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function famille(): BelongsTo
    {
        return $this->belongsTo(FamilleProduit::class, 'famille_id');
    }

    public function produitParent(): BelongsTo
    {
        return $this->belongsTo(Produit::class, 'produit_parent_id');
    }

    public function produitsFils(): HasMany
    {
        return $this->hasMany(Produit::class, 'produit_parent_id');
    }

    public function lignesCommandeFournisseur(): HasMany
    {
        return $this->hasMany(LigneCommandeFournisseur::class);
    }

    public function lignesBonEntree(): HasMany
    {
        return $this->hasMany(LigneBonEntree::class);
    }

    public function lignesCommandeClient(): HasMany
    {
        return $this->hasMany(LigneCommandeClient::class);
    }

    public function lignesBonSortie(): HasMany
    {
        return $this->hasMany(LigneBonSortie::class);
    }

    public function estEnRuptureDeStock(): bool
    {
        return $this->stock_actuel <= $this->stock_minimum;
    }
}
