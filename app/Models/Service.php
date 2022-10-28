<?php

namespace App\Models;

use App\Model\AffectationServiceConsulat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    protected $table = 'zen_service';
    protected $primaryKey = 'id';
    protected $fillable = [
        'libelle', 'description', 'departement', 'inscription', 'service_com'
    ];

    protected $appends = ['nombre_employes', 'has_charger_com'];
    protected $with = ['departement'];
    // protected $with = ['institution'];


    public function getNombreEmployesAttribute()
    {
        return $this->employes()->count();
    }


    public function getHasChargerComAttribute()
    {
        $charger_com = $this->employes()->where('charger_com', 1)->get();
        return !$charger_com->isEmpty();
    }



    public function departement()
    {
        return $this->belongsTo(Departement::class, 'departement');
    }

    private function employes()
    {
        return $this->belongsToMany(Employe::class, AffectationEmployeService::class, 'service', 'employe');
    }


    public function ministeres()
    {
        return $this->belongsToMany(Ministere::class, AffectationServiceMinistere::class, 'service', 'ministere');
    }


    public function ambassades()
    {
        return $this->belongsToMany(Ambassade::class, AffectationServiceAmbassade::class, 'service', 'ambassade');
    }


    public function consulats()
    {
        return $this->belongsToMany(consulat::class, AffectationServiceConsulat::class, 'service', 'consulat');
    }


    public function bureaux()
    {
        return $this->belongsToMany(Bureau::class, AffectationServiceBureau::class, 'service', 'bureau');
    }

    public function affectation_entite_diplomatiques()
    {
        return $this->hasMany(AffectationEntiteDiplomatiqueServiceCommunication::class, 'service')->whereNull('deleted_at');
    }

    public function getInstitutionAttribute()
    {
        if ($this->ministeres()->get()->isNotEmpty()) {
            return $this->ministeres()->get()->first();
        } else if ($this->ambassades()->get()->isNotEmpty()) {
            return $this->ambassades()->get()->first();
        } else if ($this->consulats()->get()->isNotEmpty()) {
            return $this->consulats()->get()->first();
        } else if ($this->bureaux()->get()->isNotEmpty()) {
            return $this->bureaux()->get()->first();
        }

        return null;
        // return $this->ministeres()->get()->isNotEmpty();
    }
}
