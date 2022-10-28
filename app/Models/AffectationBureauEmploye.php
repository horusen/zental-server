<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationBureauEmploye extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_bureau_employe';
    protected $primaryKey = 'id';
    protected $fillable = ['bureau', 'employe', 'inscription'];
}
