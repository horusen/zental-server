<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationBureauPasserelle extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_bureau_passerelle';
    protected $primaryKey = 'id';
    protected $fillable = [
        'bureau', 'passerelle', 'inscription'
    ];
}
