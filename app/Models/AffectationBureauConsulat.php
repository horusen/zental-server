<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationBureauConsulat extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_bureau_consulat';
    protected $primaryKey = 'id';
    protected $fillable = ['bureau', 'consulat', 'inscription'];
}
