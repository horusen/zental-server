<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationReactionConsulat extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_reaction_consulat';
    protected $primaryKey = 'id';
    protected $fillable = ['reaction', 'inscription', 'consulat'];
}
