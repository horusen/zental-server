<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationDomaineAmbassade extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_domaine_ambassade';
    protected $primaryKey = 'id';
    protected $fillable = [
        'domaine', 'ambassade', 'inscription'
    ];
}
