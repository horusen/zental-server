<?php

namespace App\Models;

use App\Http\Controllers\TypeContratController;
use App\Shared\Models\Fichier\Fichier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emploie extends Model
{
    use SoftDeletes;
    protected $table = 'zen_emploie';
    protected $primaryKey = 'id';
    protected $fillable = [
        'libelle', 'description', 'inscription', 'domaine', 'niveau', 'type_contrat', 'debut', 'fin',  'etablissement', 'user', 'lieu'
    ];


    protected $with = ['domaine', 'type_contrat', 'fichier_joint.extension', 'lieu.pays'];


    public function domaine()
    {
        return $this->belongsTo(Domaine::class, 'domaine');
    }

    public function type_contrat()
    {
        return $this->belongsTo(TypeContrat::class, 'type_contrat');
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
