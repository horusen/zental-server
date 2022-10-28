<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bureau extends Model
{
    use SoftDeletes;
    protected $table = 'zen_bureau';
    protected $primaryKey = 'id';
    protected $fillable = [
        'entite_diplomatique', 'inscription',
    ];

    protected $with = ['entite_diplomatique.pays_siege', 'entite_diplomatique.pays_origine'];


    protected $appends = ['liaison', 'passerelle'];


    public function entite_diplomatique()
    {
        return $this->belongsTo(EntiteDiplomatique::class, 'entite_diplomatique');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, AffectationServiceBureau::class, 'bureau', 'service');
    }


    public function passerelles()
    {
        return $this->belongsToMany(Passerelle::class, AffectationBureauPasserelle::class, 'bureau', 'passerelle')->whereNull('zen_affectation_bureau_passerelle.deleted_at');
    }


    public function liaisons()
    {
        return $this->belongsToMany(Liaison::class, AffectationBureauLiaison::class, 'bureau', 'liaison')->whereNull('zen_affectation_bureau_liaison.deleted_at');
    }


    public function getLiaisonAttribute()
    {
        return $this->liaisons()->get()->first();
    }


    public function getPasserelleAttribute()
    {
        return $this->passerelles()->get()->first();
    }

    public function pays()
    {
        return $this->belongsTo(Domaine::class, 'pays');
    }

    public function getAmbassadeAttribute()
    {
        return $this->ambassades()->get()->first();
    }


    public function getConsulatAttribute()
    {
        return $this->consulats()->get()->first();
    }


    public function getMinistereAttribute()
    {
        return $this->ministeres()->get()->first();
    }

    public function ministeres()
    {
        return $this->belongsToMany(Ministere::class, AffectationBureauMinistere::class, 'bureau', 'ministere');
    }


    public function ambassades()
    {
        return $this->belongsToMany(Ambassade::class, AffectationBureauAmbassade::class, 'bureau', 'ambassade');
    }


    public function consulats()
    {
        return $this->belongsToMany(Consulat::class, AffectationBureauConsulat::class, 'bureau', 'consulat');
    }
}
