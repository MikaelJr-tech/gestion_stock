<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BonEntree extends Model
{
    use BelongsToTenant;

    protected $table = 'bons_entree';

    protected $fillable = [
        'tenant_id',
        'user_id',
        'numero',
        'type',
        'date_entree',
        'source',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'date_entree' => 'date',
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
        return $this->hasMany(LigneBonEntree::class, 'bon_entree_id');
    }
}
