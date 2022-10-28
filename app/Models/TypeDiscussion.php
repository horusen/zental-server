<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeDiscussion extends Model
{
    use SoftDeletes;
    protected $table = 'zen_type_discussion';
    protected $primaryKey = 'id';
    protected $fillable = ['libelle', 'inscription', 'description'];
}
