<?php

namespace App\Models;

use App\Model\AffectationServiceConsulat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Consulat extends Model
{
    use SoftDeletes;
    protected $table = 'zen_consulat';
    protected $primaryKey = 'id';
    protected $fillable = ['entite_diplomatique', 'inscription'];
    protected $with = ['entite_diplomatique.pays_siege', 'entite_diplomatique.pays_origine'];
    protected $appends = ['user_inscription_consulaire', 'addresse'];

    public function entite_diplomatique()
    {
        return $this->belongsTo(EntiteDiplomatique::class, 'entite_diplomatique');
    }


    public function getAddresseAttribute()
    {
        return $this->entite_diplomatique()->get()->first()->addresses()->get()->first();
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, AffectationServiceConsulat::class, 'consulat', 'service');
    }

    public function ministeres()
    {
        return $this->belongsToMany(Ministere::class, AffectationConsulatMinistere::class, 'consulat', 'ministere');
    }


    public function ambassades()
    {
        return $this->belongsToMany(Ambassade::class, AffectationConsulatAmbassade::class, 'consulat', 'ambassade');
    }

    public function bureaux()
    {
        return $this->belongsToMany(Bureau::class, AffectationBureauConsulat::class, 'consulat', 'bureau');
    }


    public function inscription_consulaires()
    {
        return $this->belongsToMany(InscriptionConsulaire::class, AffectationInscriptionConsulaireConsulat::class, 'consulat', 'inscription_consulaire');
    }

    public function getUserInscriptionConsulaireAttribute()
    {
        $inscription_consulaire = $this->inscription_consulaires()->where('user', Auth::id())->latest()->get()->first();

        if (isset($inscription_consulaire) && ($inscription_consulaire->etat == 1 || $inscription_consulaire->etat == 2)) {
            return $inscription_consulaire->etat;
        }

        return null;
    }
}
