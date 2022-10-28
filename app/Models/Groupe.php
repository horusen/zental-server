<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Groupe extends Model
{
    use SoftDeletes;
    protected $table = 'zen_groupe';
    protected $primaryKey = 'id';
    protected $fillable = ['libelle', 'inscription', 'description'];
    protected $appends = ['user_membership', 'user_demande', 'nombre_membres', 'nombre_demandes'];

    public function membres()
    {
        return $this->hasMany(MembreGroupe::class, 'groupe')->whereNull('deleted_at');
    }

    public function demandes()
    {
        return $this->hasMany(DemandeAdhesion::class, 'groupe')->whereNull('deleted_at')->whereNull('validation');
    }


    public function getUserMembershipAttribute()
    {
        return $this->membres()->where('membre', Auth::id())->first();
    }


    public function getUserDemandeAttribute()
    {
        return $this->demandes()->where('user', Auth::id())->first();
    }

    public function getNombreMembresAttribute()
    {
        return $this->membres()->count();
    }

    public function getNombreDemandesAttribute()
    {
        return $this->demandes()->count();
    }
}
