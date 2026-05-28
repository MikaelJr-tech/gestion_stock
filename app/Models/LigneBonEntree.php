<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LigneBonEntree extends Model
{
    protected $table = 'lignes_bon_entree';

    protected $fillable = [
        'bon_entree_id',
        'produit_id',
        'quantite',
        'valeur_unitaire',
    ];

    public function bonEntree(): BelongsTo
    {
        return $this->belongsTo(BonEntree::class, 'bon_entree_id');
    }

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }
}
