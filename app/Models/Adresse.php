<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adresse extends Model
{
    use SoftDeletes;
    protected $table = 'zen_adresse';
    protected $primaryKey = 'id';
    protected $fillable = [
        'ville', 'adresse', 'inscription'
    ];

    protected $with = ['ville'];

    public function ville()
    {
        return $this->belongsTo(Ville::class, 'ville');
    }


    public function entite_diplomatiques()
    {
        return $this->belongsToMany(EntiteDiplomatique::class, AffectationAdresseEntiteDiplomatique::class, 'addresse', 'entite_diplomatique');
    }
}
