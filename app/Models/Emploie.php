<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emploie extends Model
{
    use SoftDeletes;
    protected $table = 'zen_emploie';
    protected $primaryKey = 'id';
    protected $fillable = [
        'libelle', 'description', 'inscription', 'domaine', 'niveau', 'type_contrat', 'debut', 'fin', 'fichier_joint', 'etablissement'
    ];
}
