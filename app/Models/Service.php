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
        'libelle', 'description', 'departement', 'inscription'
    ];

    protected $appends = ['nombre_employes'];
    protected $with = ['departement'];


    public function getNombreEmployesAttribute()
    {
        return $this->employes()->count();
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
}
