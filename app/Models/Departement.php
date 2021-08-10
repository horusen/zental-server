<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departement extends Model
{
    use SoftDeletes;
    protected $table = 'zen_departement';
    protected $primaryKey = 'id';
    protected $fillable = [
        'libelle', 'description', 'inscription', 'domaine'
    ];

    protected $with = ['domaine'];


    public function domaine()
    {
        return $this->belongsTo(Domaine::class, 'domaine');
    }

    public function ministeres()
    {
        return $this->belongsToMany(Ministere::class, AffectationDepartementMinistere::class, 'departement', 'ministere');
    }


    public function ambassades()
    {
        return $this->belongsToMany(Ambassade::class, AffectationDepartementAmbassade::class, 'departement', 'ambassade');
    }
}
