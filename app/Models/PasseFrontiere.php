<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PasseFrontiere extends Model
{
    use SoftDeletes;
    protected $table = 'zen_passe_frontiere';
    protected $primaryKey = 'id';
    protected $fillable = [
        'libelle', 'description', 'inscription'
    ];
}
