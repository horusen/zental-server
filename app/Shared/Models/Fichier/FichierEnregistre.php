<?php

namespace App\Shared\Models\Fichier;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FichierEnregistre extends Model
{
    use SoftDeletes;
    protected $table = 'exp_fichier_enregistre';
    protected $primaryKey = 'id';
    protected $fillable = ['fichier', 'inscription'];
}
