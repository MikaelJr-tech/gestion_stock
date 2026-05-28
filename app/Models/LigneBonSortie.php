<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LigneBonSortie extends Model
{
    protected $table = 'lignes_bon_sortie';

    protected $fillable = [
        'bon_sortie_id',
        'produit_id',
        'quantite',
        'valeur_unitaire',
    ];

    public function bonSortie(): BelongsTo
    {
        return $this->belongsTo(BonSortie::class, 'bon_sortie_id');
    }

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }
}
