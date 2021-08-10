<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MotDuPresident extends Model
{
    use SoftDeletes;
    protected $table = 'zen_mot_du_president';
    protected $primaryKey = 'id';
    protected $fillable = ['description', 'pays', 'inscription'];
}
