<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fonction extends Model
{
    use SoftDeletes;
    protected $table = 'zen_fonction';
    protected $primaryKey = 'id';
    protected $fillable = [
        'libelle', 'description', 'inscription'
    ];



    public function ministeres()
    {
        return $this->belongsToMany(Ministere::class, AffectationFonctionMinistere::class, 'fonction', 'ministere');
    }


    public function ambassades()
    {
        return $this->belongsToMany(Ambassade::class, AffectationFonctionAmbassade::class, 'fonction', 'ambassade');
    }


    public function consulats()
    {
        return $this->belongsToMany(Consulat::class, AffectationFonctionConsulat::class, 'fonction', 'consulat');
    }


    public function bureaux()
    {
        return $this->belongsToMany(Bureau::class, AffectationFonctionBureau::class, 'fonction', 'bureau');
    }
}
