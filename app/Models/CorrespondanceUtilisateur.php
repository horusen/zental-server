<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CorrespondanceUtilisateur extends Model
{
    use SoftDeletes;
    protected $table = 'zen_correspondance_utilisateur';
    protected $primaryKey = 'id';
    protected $fillable = ['user1', 'inscription', 'user2', 'discussion'];
    protected $with = ['user1', 'user2'];


    public function user1()
    {
        return $this->belongsTo(User::class, 'user1');
    }


    public function user2()
    {
        return $this->belongsTo(User::class, 'user2');
    }
}
