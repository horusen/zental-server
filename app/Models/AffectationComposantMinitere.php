<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationComposantMinitere extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_composant_ministere';
    protected $primaryKey = 'id';
    protected $fillable = [
        'ministere', 'composant', 'inscription'
    ];
}
