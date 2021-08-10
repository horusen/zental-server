<?php

namespace App\Shared\Models\Fichier;

use App\Models\Reaction;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fichier extends Model
{
    use SoftDeletes;
    protected $table  = 'exp_fichier';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'extension',
        'path',
        'size',
        'inscription',
    ];

    protected $with = ['extension'];
    protected $appends = ['has_password'];

    public function reactions()
    {
        return $this->hasMany(Reaction::class, 'file');
    }

    public function extension()
    {
        return $this->belongsTo(ExtensionFichier::class, 'extension');
    }

    public function getHasPasswordAttribute()
    {
        $passwordFichier = $this->passwordFichier()->where('inscription', $this->inscription)->get()->first();
        if (isset($passwordFichier)) {
            return true;
        }

        return false;
    }

    public function dossiers()
    {
        return $this->belongsToMany(DossierFichier::class, 'exp_affectation_fichier_dossier', 'fichier', 'dossier');
    }

    public function passwordFichier()
    {
        return $this->hasMany(PasswordFichier::class, 'fichier');
    }

    public function affectation_dossiers()
    {
        return $this->hasMany(AffectationFichierDossier::class, 'fichier');
    }

    public function inscription()
    {
        return $this->belongsTo(User::class, 'inscription');
    }

    public function getUserAttribute()
    {
        return [
            'id' => $this->inscription()->get()->first()->id_inscription,
            'photo' => $this->inscription()->get()->first()->photo()->get()->first()->path,
            'nom_complet' => $this->inscription()->get()->first()->nom_complet,
        ];
    }
}
