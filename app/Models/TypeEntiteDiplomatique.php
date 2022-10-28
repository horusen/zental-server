<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeEntiteDiplomatique extends Model
{
    use SoftDeletes;
    protected $table = 'zen_type_entite_diplomatique';
    protected $primaryKey = 'id';
    protected $fillable = ['libelle', 'inscription', 'description'];
}
