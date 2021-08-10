<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationBureauLiaison extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_bureau_liaison';
    protected $primaryKey = 'id';
    protected $fillable = [
        'bureau', 'liaison', 'inscription'
    ];
}
