<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationConsulatMinistere extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_consulat_ministere';
    protected $primaryKey = 'id';
    protected $fillable = [
        'consulat', 'ministere', 'inscription'
    ];
}
