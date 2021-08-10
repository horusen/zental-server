<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conjoint extends Model
{
    use SoftDeletes;
    protected $table = 'zen_conjoint';
    protected $primaryKey = 'id';
    protected $fillable = [
        'conjoint1', 'conjoint2', 'inscription', 'meme_pays', 'meme_nationalite'
    ];
}
