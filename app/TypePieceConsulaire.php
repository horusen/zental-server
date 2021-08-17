<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypePieceConsulaire extends Model
{
    use SoftDeletes;
    protected $table = 'zen_type_piece_consulaire';
    protected $primaryKey = 'id';
    protected $fillable = ['libelle', 'description', 'inscription'];
}
