<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Liaison extends Model
{
    use SoftDeletes;
    protected $table = 'zen_liaison';
    protected $primaryKey = 'id';
    protected $fillable = ['entite_diplomatique', 'inscription'];
    protected $with = ['entite_diplomatique.pays_siege', 'ambassades'];

    public function entite_diplomatique()
    {
        return $this->belongsTo(EntiteDiplomatique::class, 'entite_diplomatique');
    }


    public function bureaux()
    {
        return $this->belongsToMany(Bureau::class, AffectationBureauLiaison::class, 'liaison', 'bureau');
    }


    public function getBureauAttribute()
    {
        return $this->bureaux()->get()->first();
    }


    public function ministeres()
    {
        return $this->belongsToMany(Ministere::class, AffectationLiaisonMinistere::class, 'liaison', 'ministere');
    }


    public function ambassades()
    {
        return $this->belongsToMany(Ambassade::class, AffectationLiaisonAmbassade::class, 'liaison', 'ambassade');
    }
}
