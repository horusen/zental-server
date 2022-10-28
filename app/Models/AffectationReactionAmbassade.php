<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationReactionAmbassade extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_reaction_ambassade';
    protected $primaryKey = 'id';
    protected $fillable = ['reaction', 'inscription', 'ambassade'];
}
