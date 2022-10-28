<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationPosteBureau extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_poste_bureau';
    protected $primaryKey = 'id';
    protected $fillable = ['poste', 'inscription', 'bureau'];
}
