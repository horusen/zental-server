<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nationalite extends Model
{
    use SoftDeletes;
    protected $table = 'zen_nationalite';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user', 'pays', 'inscription'
    ];
}
