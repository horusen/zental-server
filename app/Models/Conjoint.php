<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conjoint extends Model
{
    use SoftDeletes;
    protected $table = 'zen_conjoint';
    protected $primaryKey = 'id';
    protected $fillable = [
        'conjoint1', 'conjoint2', 'inscription', 'meme_pays', 'meme_nationalite', 'vivre_ensemble'
    ];


    protected $with = ['conjoint1', 'conjoint2'];


    public function conjoint1()
    {
        return $this->belongsTo(User::class, 'conjoint1');
    }


    public function conjoint2()
    {
        return $this->belongsTo(User::class, 'conjoint2');
    }
}
