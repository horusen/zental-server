<?php

namespace App\Shared\Models\Fichier;

use Illuminate\Database\Eloquent\Model;

class TypeExtensionFichier extends Model
{
    protected $table  = 'exp_type_extension_fichier';
    protected $primaryKey = 'id';
    protected $fillable = [
        'libelle',
        'type',
    ];
}
