<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'tenant_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function bonsCommandeFournisseur()
    {
        return $this->hasMany(BonCommandeFournisseur::class);
    }

    public function facturesFournisseur()
    {
        return $this->hasMany(FactureFournisseur::class);
    }

    public function bonsEntree()
    {
        return $this->hasMany(BonEntree::class);
    }

    public function commandesClient()
    {
        return $this->hasMany(CommandeClient::class);
    }

    public function facturesClient()
    {
        return $this->hasMany(FactureClient::class);
    }

    public function bonsSortie()
    {
        return $this->hasMany(BonSortie::class);
    }

    public function versementsBanque()
    {
        return $this->hasMany(VersementBanque::class);
    }
}
