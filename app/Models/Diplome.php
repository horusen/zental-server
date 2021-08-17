<?php

namespace App\Models;

use App\Shared\Models\Fichier\Fichier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diplome extends Model
{
    use SoftDeletes;
    protected $table = 'zen_diplome';
    protected $primaryKey = 'id';
    protected $fillable = [
        'libelle', 'description', 'inscription', 'domaine', 'niveau', 'annee_obtention', 'etablissement', 'user', 'lieu'
    ];

    protected $with = ['domaine', 'niveau', 'fichier_joint', 'lieu.pays'];



    public function domaine()
    {
        return $this->belongsTo(Domaine::class, 'domaine');
    }

    public function niveau()
    {
        return $this->belongsTo(Niveau::class, 'niveau');
    }

    public function fichier_joint()
    {
        return $this->belongsTo(Fichier::class, 'fichier_joint');
    }


    public function lieu()
    {
        return $this->belongsTo(Ville::class, 'lieu');
    }
}
