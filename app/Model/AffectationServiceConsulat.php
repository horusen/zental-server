<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationServiceConsulat extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_service_consulat';
    protected $primaryKey = 'id';
    protected $fillable = [
        'service', 'consulat', 'inscription'
    ];
}
