<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationBureauMinistere extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_bureau_ministere';
    protected $primaryKey = 'id';
    protected $fillable = [
        'bureau', 'ministere', 'inscription'
    ];
}
