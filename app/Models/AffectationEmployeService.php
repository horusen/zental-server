<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationEmployeService extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_employe_service';
    protected $primaryKey = 'id';
    protected $fillable = [
        'service', 'employe', 'inscription'
    ];
}
