<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DomaineInstitution extends Model
{
    use SoftDeletes;
    protected $table = 'zen_domaine_institution';
    protected $primaryKey = 'id';
    protected $fillable = [
        'libelle', 'description', 'inscription'
    ];



    public function ministeres()
    {
        return $this->belongsToMany(Ministere::class, AffectationDomaineMinistere::class, 'domaine', 'ministere');
    }


    public function ambassades()
    {
        return $this->belongsToMany(Ambassade::class, AffectationDomaineAmbassade::class, 'domaine', 'ambassade');
    }


    public function consulats()
    {
        return $this->belongsToMany(Consulat::class, AffectationDomaineConsulat::class, 'domaine', 'consulat');
    }

    public function bureaux()
    {
        return $this->belongsToMany(Bureau::class, AffectationDomaineBureau::class, 'domaine', 'bureau');
    }
}
