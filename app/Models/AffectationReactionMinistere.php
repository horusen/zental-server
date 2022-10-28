<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationReactionMinistere extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_reaction_ministere';
    protected $primaryKey = 'id';
    protected $fillable = ['reaction', 'inscription', 'ministere'];
}
