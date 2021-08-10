<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeContact extends Model
{
    use SoftDeletes;
    protected $table = 'zen_type_contact';
    protected $primaryKey = 'id';
    protected $fillable = [
        'libelle', 'description', 'inscription'
    ];
}
