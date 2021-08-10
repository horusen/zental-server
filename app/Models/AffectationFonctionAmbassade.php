<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationFonctionAmbassade extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_fonction_ambassade';
    protected $primaryKey = 'id';
    protected $fillable = [
        'fonction', 'ambassade', 'inscription'
    ];
}
