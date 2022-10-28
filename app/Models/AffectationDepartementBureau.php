<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationDepartementBureau extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_departement_bureau';
    protected $primaryKey = 'id';
    protected $fillable = ['bureau', 'inscription', 'departement'];
}
