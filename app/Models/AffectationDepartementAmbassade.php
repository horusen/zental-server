<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationDepartementAmbassade extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_departement_ambassade';
    protected $primaryKey = 'id';
    protected $fillable = [
        'departement', 'ambassade', 'inscription'
    ];
}
