<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employe extends Model
{
    use SoftDeletes;
    protected $table = 'zen_employe';
    protected $primaryKey = 'id';
    protected $fillable = [
        'employe', 'fonction', 'inscription', 'poste', 'debut', 'fin', 'note', 'charger_com'
    ];


    protected $with = ['employe', 'poste', 'fonction'];

    public function employe()
    {
        return $this->belongsTo(User::class, 'employe');
    }


    public function fonction()
    {
        return $this->belongsTo(Fonction::class, 'fonction');
    }


    public function poste()
    {
        return $this->belongsTo(Poste::class, 'poste');
    }


    public function services()
    {
        return $this->belongsToMany(Service::class, AffectationEmployeService::class, 'employe', 'service');
    }


    public function bureaux()
    {
        return $this->belongsToMany(Bureau::class, AffectationEmployeBureau::class, 'employe', 'bureau');
    }


    public function affectation_ministeres()
    {
        return $this->hasMany(AffectationMinistreMinistere::class, 'ministre');
    }


    public function affectation_services()
    {
        return $this->hasMany(AffectationEmployeService::class, 'employe');
    }

    public function affectation_ambassades()
    {
        return $this->hasMany(AffectationAmbassadeurAmbassade::class, 'ambassadeur');
    }

    public function affectation_consulats()
    {
        return $this->hasMany(AffectationConsuleConsulat::class, 'consule');
    }
}
