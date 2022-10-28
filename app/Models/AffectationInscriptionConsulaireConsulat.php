<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationInscriptionConsulaireConsulat extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_inscription_consulaire_consulat';
    protected $primaryKey = 'id';
    protected $fillable = ['consulat', 'inscription_consulaire', 'inscription'];
}
