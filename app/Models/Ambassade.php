<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Ambassade extends Model
{
    use SoftDeletes;
    protected $table = 'zen_ambassade';
    protected $primaryKey = 'id';
    protected $fillable = ['entite_diplomatique', 'inscription'];
    protected $with = ['entite_diplomatique.pays_siege', 'entite_diplomatique.pays_origine'];
    protected $appends = ['user_inscription_consulaire'];

    public function entite_diplomatique()
    {
        return $this->belongsTo(EntiteDiplomatique::class, 'entite_diplomatique');
    }


    public function bureaux()
    {
        return $this->belongsToMany(Bureau::class, AffectationBureauAmbassade::class, 'ambassade', 'bureau');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, AffectationServiceAmbassade::class, 'ambassade', 'service');
    }


    public function consulats()
    {
        return $this->belongsToMany(Consulat::class, AffectationConsulatAmbassade::class, 'ambassade', 'consulat');
    }

    public function inscription_consulaires()
    {
        return $this->belongsToMany(InscriptionConsulaire::class, AffectationInscriptionConsulaireAmbassade::class, 'ambassade', 'inscription_consulaire');
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
