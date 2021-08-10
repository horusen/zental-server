<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class venirChezNous extends Model
{
    use SoftDeletes;
    protected $table = 'zen_venir_chez_nous';
    protected $primaryKey = 'id';
    protected $fillable = ['description', 'pays', 'inscription'];
}
