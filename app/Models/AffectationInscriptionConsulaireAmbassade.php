<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationInscriptionConsulaireAmbassade extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_inscription_consulaire_ambassade';
    protected $primaryKey = 'id';
    protected $fillable = ['inscription_consulaire', 'ambassade', 'inscription'];
}
