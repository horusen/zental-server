<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationServiceMinistere extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_service_ministere';
    protected $primaryKey = 'id';
    protected $fillable = [
        'service', 'ministere', 'inscription'
    ];
}
