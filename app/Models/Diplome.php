<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diplome extends Model
{
    use SoftDeletes;
    protected $table = 'zen_diplome';
    protected $primaryKey = 'id';
    protected $fillable = [
        'libelle', 'description', 'inscription', 'domaine', 'niveau', 'annee_obtention', 'etablissement', 'fichier_joint',
    ];
}
