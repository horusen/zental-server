<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationDepartementMinistere extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_departement_ministere';
    protected $primaryKey = 'id';
    protected $fillable = [
        'departement', 'ministere', 'inscription'
    ];
}
