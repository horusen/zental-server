<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelationFamiliale extends Model
{
    use SoftDeletes;
    use \Awobaz\Compoships\Compoships;
    protected $table = 'zen_relation_familiale';
    protected $primaryKey = 'id';
    protected $fillable = [
        'type', 'user', 'inscription', 'membre_famille',
    ];

    protected $with = ['type', 'membre_famille'];


    public function type()
    {
        return $this->belongsTo(TypeRelationFamiliale::class, 'type');
    }

    public function membre_famille()
    {
        return $this->belongsTo(User::class, 'membre_famille');
    }


    // public function
}
