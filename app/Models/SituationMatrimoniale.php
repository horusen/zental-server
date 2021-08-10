<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SituationMatrimoniale extends Model
{
    use SoftDeletes;
    protected $table = 'zen_situation_matrimoniale';
    protected $primaryKey = 'id';
    protected $fillable = [
        'libelle', 'description', 'inscription'
    ];
}
