<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationLiaisonConsulat extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_liaison_consulat';
    protected $primaryKey = 'id';
    protected $fillable = ['liaison', 'consulat', 'inscription'];
}
