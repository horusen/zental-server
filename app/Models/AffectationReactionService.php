<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationReactionService extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_reaction_service';
    protected $primaryKey = 'id';
    protected $fillable = ['reaction', 'service', 'inscription'];
}
