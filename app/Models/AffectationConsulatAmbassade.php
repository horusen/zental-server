<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationConsulatAmbassade extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_consulat_ambassade';
    protected $primaryKey = 'id';
    protected $fillable = [
        'consulat', 'ambassade', 'inscription'
    ];
}
