<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationAmbassadeMinistere extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_ambassade_ministere';
    protected $primaryKey = 'id';
    protected $fillable = ['ambassade', 'ministere', 'inscription'];
}
