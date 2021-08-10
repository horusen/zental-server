<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consulat extends Model
{
    use SoftDeletes;
    protected $table = 'zen_consulat';
    protected $primaryKey = 'id';
    protected $fillable = ['entite_diplomatique', 'inscription', 'ville'];
    protected $with = ['entite_diplomatique.pays_siege', 'ville'];

    public function entite_diplomatique()
    {
        return $this->belongsTo(EntiteDiplomatique::class, 'entite_diplomatique');
    }

    public function ville()
    {
        return $this->belongsTo(Ville::class, 'ville');
    }


    public function ministeres()
    {
        return $this->belongsToMany(Ministere::class, AffectationConsulatMinistere::class, 'consulat', 'ministere');
    }


    public function ambassades()
    {
        return $this->belongsToMany(Ambassade::class, AffectationConsulatAmbassade::class, 'consulat', 'ambassade');
    }
}
