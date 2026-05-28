<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LigneCommandeFournisseur extends Model
{
    protected $table = 'lignes_commande_fournisseur';

    protected $fillable = [
        'bon_commande_id',
        'produit_id',
        'quantite_commandee',
        'quantite_recue',
        'prix_unitaire',
        'montant',
    ];

    public function bonCommande(): BelongsTo
    {
        return $this->belongsTo(BonCommandeFournisseur::class, 'bon_commande_id');
    }

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }
}
