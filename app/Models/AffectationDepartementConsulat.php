<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationDepartementConsulat extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_departement_consulat';
    protected $primaryKey = 'id';
    protected $fillable = ['departement', 'consulat', 'inscription'];
}
