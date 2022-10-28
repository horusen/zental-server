<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationDomaineBureau extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_domaine_bureau';
    protected $primaryKey = 'id';
    protected $fillable = ['domaine', 'inscription', 'bureau'];
}
