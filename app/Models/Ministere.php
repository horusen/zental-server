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
    protected $with = ['entite_diplomatique.pays_siege', 'entite_diplomatique.pays_origine'];


    public function entite_diplomatique()
    {
        return $this->belongsTo(EntiteDiplomatique::class, 'entite_diplomatique');
    }


    // public function services()
    // {
    //     return $this->belongsToMany(Service::class, AffectationServiceMinistere::class, 'ministere', 'service');
    // }

    public function ambassades()
    {
        return $this->belongsToMany(Ambassade::class, AffectationAmbassadeMinistere::class, 'ministere', 'ambassade');
    }

    public function consulats()
    {
        return $this->belongsToMany(Consulat::class, AffectationConsulatMinistere::class, 'ministere', 'consulat');
    }

    public function bureaux()
    {
        return $this->belongsToMany(Bureau::class, AffectationBureauMinistere::class, 'ministere', 'bureau');
    }


    public function adresses()
    {
        return $this->belongsToMany(Addresse::class, AffectationAdresseMinistere::class, 'ministere', 'addresse');
    }


    public function services()
    {
        return $this->belongsToMany(Service::class, AffectationServiceMinistere::class, 'ministere', 'service');
    }
}
