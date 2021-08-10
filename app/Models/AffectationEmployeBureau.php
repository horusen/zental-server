<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationEmployeBureau extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_employe_bureau';
    protected $primaryKey = 'id';
    protected $fillable = [
        'bureau', 'employe', 'inscription'
    ];
}
