<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pays extends Model
{
    use \Awobaz\Compoships\Compoships;
    protected $table = 'pays';
    protected $primaryKey = 'id';
    public $timestamps = false;



    public function  entite_diplomatiques()
    {
        return $this->hasMany(EntiteDiplomatique::class, ['pays_origine', 'pays_siege'], ['id', 'id']);
    }

    /**
     * ps: Pays siege
     * Permet d'etablir une relation avec entite_diplomatique en
     * se basant sur le pays de siege
     */
    public function ps_entite_diplomatiques()
    {
      return $this->hasMany(EntiteDiplomatique::class, 'pays_siege');
    }


    /**
     * po: Pays d'origine
     * Permet d'etablir une relation avec entite_diplomatique en
     * se basant sur le pays d'origine
     */
    public function po_entite_diplomatiques()
    {
      return $this->hasMany(EntiteDiplomatique::class, 'pays_origine');
    }
}
