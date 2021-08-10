<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationAdresseEntiteDiplomatique extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_addresse_entite_diplomatique';
    protected $primaryKey = 'id';
    protected $fillable = [
        'addresse', 'entite_diplomatique', 'inscription'
    ];
}
