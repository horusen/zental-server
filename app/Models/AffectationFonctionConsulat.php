<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationFonctionConsulat extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_fonction_consulat';
    protected $primaryKey = 'id';
    protected $fillable = ['fonction', 'consulat', 'inscription'];
}
