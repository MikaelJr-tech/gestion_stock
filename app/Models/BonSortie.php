<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BonSortie extends Model
{
    use BelongsToTenant;

    protected $table = 'bons_sortie';

    protected $fillable = [
        'tenant_id',
        'user_id',
        'numero',
        'motif',
        'date_sortie',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'date_sortie' => 'date',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lignes(): HasMany
    {
        return $this->hasMany(LigneBonSortie::class, 'bon_sortie_id');
    }
}
