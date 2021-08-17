<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelationInterpersonnelle extends Model
{
    use SoftDeletes;
    use \Awobaz\Compoships\Compoships;
    protected $table = 'zen_relation_interpersonnelle';
    protected $primaryKey = 'id';
    protected $fillable = [
        'type_relation', 'user1', 'user2',  'inscription'
    ];


    protected $with = ['user1.photo', 'user2.photo', 'type_relation'];



    public function user1()
    {
        return $this->belongsTo(User::class, 'user1');
    }


    public function user2()
    {
        return $this->belongsTo(User::class, 'user2');
    }

    public function type_relation()
    {
        return $this->belongsTo(TypeRelation::class, 'type_relation');
    }
}
