<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ministere extends Model
{
    use SoftDeletes;
    protected $table = 'zen_ministere';
    protected $primaryKey = 'id';
    protected $fillable = [
        'entite_diplomatique', 'inscription'
    ];
    protected $with = ['entite_diplomatique.pays_siege'];


    public function entite_diplomatique()
    {
        return $this->belongsTo(EntiteDiplomatique::class, 'entite_diplomatique');
    }



    public function adresses()
    {
        return $this->belongsToMany(Adresse::class, AffectationAdresseMinistere::class, 'ministere', 'adresse');
    }


    public function services()
    {
        return $this->belongsToMany(Service::class, AffectationServiceMinistere::class, 'ministere', 'service');
    }
}
