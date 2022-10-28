<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationInscriptionConsulaireLiaison extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_inscription_consulaire_liaison';
    protected $primaryKey = 'id';
    protected $fillable = ['inscription_consulaire', 'inscription', 'liaison'];
}
