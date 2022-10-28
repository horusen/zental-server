<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ressortissant extends Model
{
    use SoftDeletes;
    protected $table = 'zen_ressortissant';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user', 'addresse', 'inscription', 'tel', 'presence', 'debut', 'fin'
    ];
}
