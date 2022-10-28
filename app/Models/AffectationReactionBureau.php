<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationReactionBureau extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_reaction_bureau';
    protected $primaryKey = 'id';
    protected $fillable = ['reaction', 'inscription', 'bureau'];
}
