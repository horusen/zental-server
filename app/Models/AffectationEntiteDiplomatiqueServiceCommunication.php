<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationEntiteDiplomatiqueServiceCommunication extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_entite_diplomatique_service_communication';
    protected $primaryKey = 'id';
    protected $fillable = ['entite_diplomatique', 'service', 'inscription'];
}
