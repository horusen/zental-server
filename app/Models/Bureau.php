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
        'libelle', 'description', 'inscription', 'pays'
    ];


    // protected $appends = ['liaison'];




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
        return $this->liaisons()->with('entite_diplomatique')->get()->first();
    }


    public function getPasserelleAttribute()
    {
        return $this->passerelles()->with('entite_diplomatique')->get()->first();
    }

    public function pays()
    {
        return $this->belongsTo(Domaine::class, 'pays');
    }


    public function ministeres()
    {
        return $this->belongsToMany(Ministere::class, AffectationBureauMinistere::class, 'bureau', 'ministere');
    }


    public function ambassades()
    {
        return $this->belongsToMany(Ambassade::class, AffectationBureauAmbassade::class, 'bureau', 'ambassade');
    }
}
