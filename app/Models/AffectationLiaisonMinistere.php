<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationLiaisonMinistere extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_liaison_ministere';
    protected $primaryKey = 'id';
    protected $fillable = [
        'liaison', 'ministere', 'inscription'
    ];
}
