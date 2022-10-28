<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Liaison extends Model
{
    use SoftDeletes;
    protected $table = 'zen_liaison';
    protected $primaryKey = 'id';
    protected $fillable = ['pays_origine', 'pays_siege', 'inscription', 'date_creation'];
    protected $with = ['pays_siege', 'pays_origine'];
    protected $appends = ['consulat', 'ambassade', 'user_inscription_consulaire'];




    public function bureaux()
    {
        return $this->belongsToMany(Bureau::class, AffectationBureauLiaison::class, 'liaison', 'bureau');
    }


    public function inscriptions_consulaires()
    {
        return $this->belongsToMany(InscriptionConsulaire::class, AffectationInscriptionConsulaireLiaison::class, 'liaison', 'inscription_consulaire');
    }


    public function getUserInscriptionConsulaireAttribute()
    {
        $inscription_consulaire = $this->inscriptions_consulaires()->where('user', Auth::id())->latest()->get()->first();

        if (isset($inscription_consulaire) && ($inscription_consulaire->etat == 1 || $inscription_consulaire->etat == 2)) {
            return $inscription_consulaire->etat;
        }

        return null;
    }


    public function getBureauAttribute()
    {
        return $this->bureaux()->get()->first();
    }



    public function getConsulatAttribute()
    {
        return $this->consulats()->get()->first();
    }

    public function getAmbassadeAttribute()
    {
        return $this->ambassades()->get()->first();
    }


    public function ministeres()
    {
        return $this->belongsToMany(Ministere::class, AffectationLiaisonMinistere::class, 'liaison', 'ministere');
    }


    public function ambassades()
    {
        return $this->belongsToMany(Ambassade::class, AffectationLiaisonAmbassade::class, 'liaison', 'ambassade');
    }


    public function consulats()
    {
        return $this->belongsToMany(Consulat::class, AffectationLiaisonConsulat::class, 'liaison', 'consulat');
    }

    public function pays_siege()
    {
        return $this->belongsTo(Pays::class, 'pays_siege');
    }

    public function pays_origine()
    {
        return $this->belongsTo(Pays::class, 'pays_origine');
    }
}
