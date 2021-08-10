<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelationInterpersonnelle extends Model
{
    use SoftDeletes;
    protected $table = 'zen_relation_interpersonnelle';
    protected $primaryKey = 'id';
    protected $fillable = [
        'type_relation', 'user1', 'user2',  'inscription'
    ];
}
