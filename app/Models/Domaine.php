<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Domaine extends Model
{
    use SoftDeletes;
    protected $table = 'exp_domaine';
    protected $primaryKey = 'id';
    protected $fillable = ['libelle', 'description', 'inscription'];


    public function ministeres()
    {
        return $this->belongsToMany(Ministere::class, AffectationDomaineMinistere::class, 'domaine', 'ministere');
    }


    public function ambassades()
    {
        return $this->belongsToMany(Ambassade::class, AffectationDomaineAmbassade::class, 'domaine', 'ambassade');
    }
}
