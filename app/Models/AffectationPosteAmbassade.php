<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationPosteAmbassade extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_poste_ambassade';
    protected $primaryKey = 'id';
    protected $fillable = [
        'poste', 'ambassade', 'inscription'
    ];
}
