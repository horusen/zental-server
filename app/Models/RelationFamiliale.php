<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelationFamiliale extends Model
{
    use SoftDeletes;
    protected $table = 'zen_relation_familiale';
    protected $primaryKey = 'id';
    protected $fillable = [
        'type', 'user', 'inscription', 'membre_famille',
    ];
}
