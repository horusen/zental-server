<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EtatInscriptionConsulaire extends Model
{
    use SoftDeletes;
    protected $table = 'zen_etat_inscription_consulaire';
    protected $primaryKey = 'id';
    protected $fillable = ['libelle', 'description', 'inscription'];
}
