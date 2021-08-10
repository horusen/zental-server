<?php

namespace App\Shared\Models\Fichier;

use Illuminate\Database\Eloquent\Model;

class DossierFichier extends Model
{
    protected $table  = 'exp_dossier_fichier';
    protected $primaryKey = 'id';
    protected $fillable = [
        'libelle',
        'inscription',
    ];

    protected $appends = ['user'];

    public function fichiers()
    {
        return $this->belongsToMany(Fichier::class, 'exp_affectation_fichier_dossier', 'dossier', 'fichier');
    }
}
