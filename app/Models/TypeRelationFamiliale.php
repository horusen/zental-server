<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeFamille extends Model
{
    use SoftDeletes;
    protected $table = 'zen_type_relation_familiale';
    protected $primaryKey = 'id';
    protected $fillable = [
        'libelle', 'description', 'inscription'
    ];
}
