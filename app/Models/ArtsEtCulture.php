<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArtsEtCulture extends Model
{
    use SoftDeletes;
    protected $table = 'zen_arts_et_cultures';
    protected $primaryKey = 'id';
    protected $fillable = ['description', 'pays', 'inscription'];
}
