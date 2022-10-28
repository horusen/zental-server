<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationDomaineConsulat extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_domaine_consulat';
    protected $primaryKey = 'id';
    protected $fillable = ['domaine', 'consulat', 'inscription'];
}
