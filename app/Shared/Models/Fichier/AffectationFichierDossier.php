<?php

namespace App\Shared\Models\Fichier;

use Illuminate\Database\Eloquent\Model;

class AffectationFichierDossier extends Model
{
    protected $table  = 'exp_affectation_fichier_dossier';
    protected $primaryKey = 'id';
    protected $fillable = [
        'fichier',
        'dossier',
        'inscription',
    ];
}
