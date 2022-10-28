<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationServiceBureau extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_service_bureau';
    protected $primaryKey = 'id';
    protected $fillable = ['service', 'bureau', 'inscription'];
}
