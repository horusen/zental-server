<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationLiaisonAmbassade extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_liaison_ambassade';
    protected $primaryKey = 'id';
    protected $fillable = [
        'liaison', 'ambassade', 'inscription'
    ];
}
