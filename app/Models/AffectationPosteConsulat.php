<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationPosteConsulat extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_poste_consulat';
    protected $primaryKey = 'id';
    protected $fillable = ['poste', 'consulat', 'inscription'];
}
