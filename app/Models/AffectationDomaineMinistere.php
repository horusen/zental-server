<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationDomaineMinistere extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_domaine_ministere';
    protected $primaryKey = 'id';
    protected $fillable = [
        'domaine', 'ministere', 'inscription'
    ];
}
