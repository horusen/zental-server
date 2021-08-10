<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationServiceAmbassade extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_service_ambassade';
    protected $primaryKey = 'id';
    protected $fillable = [
        'service', 'ambassade', 'inscription'
    ];
}
