<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poste extends Model
{
    use SoftDeletes;
    protected $table = 'zen_poste';
    protected $primaryKey = 'id';
    protected $fillable = [
        'libelle', 'description', 'inscription', 'domaine'
    ];

    protected $with = ['domaine'];

    public function domaine()
    {
        return $this->belongsTo(Domaine::class, 'domaine');
    }

    public function bureaux()
    {
        return $this->belongsToMany(Bureau::class, AffectationPosteBureau::class, 'poste', 'bureau');
    }


    public function ministeres()
    {
        return $this->belongsToMany(Ministere::class, AffectationPosteMinistere::class, 'poste', 'ministere');
    }


    public function ambassades()
    {
        return $this->belongsToMany(Ambassade::class, AffectationPosteAmbassade::class, 'poste', 'ambassade');
    }


    public function consulats()
    {
        return $this->belongsToMany(Consulat::class, AffectationPosteConsulat::class, 'poste', 'consulat');
    }
}
