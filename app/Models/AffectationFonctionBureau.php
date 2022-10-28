<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationFonctionBureau extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_fonction_bureau';
    protected $primaryKey = 'id';
    protected $fillable = ['fonction', 'inscription', 'bureau'];
}
