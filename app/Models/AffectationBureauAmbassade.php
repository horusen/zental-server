<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationBureauAmbassade extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_bureau_ambassade';
    protected $primaryKey = 'id';
    protected $fillable = [
        'bureau', 'ambassade', 'inscription'
    ];
}
