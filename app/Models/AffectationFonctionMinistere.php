<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationFonctionMinistere extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_fonction_ministere';
    protected $primaryKey = 'id';
    protected $fillable = [
        'fonction', 'ministere', 'inscription'
    ];
}
