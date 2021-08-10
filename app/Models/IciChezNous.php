<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IciChezNous extends Model
{
    use SoftDeletes;
    protected $table = 'zen_ici_chez_nous';
    protected $primaryKey = 'id';
    protected $fillable = ['description', 'pays', 'inscription'];
}
