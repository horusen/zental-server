<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationConsuleConsulat extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_consule_consulat';
    protected $primaryKey = 'id';
    protected $fillable = [
        'consulat', 'consulat', 'inscription', 'en_fonction'
    ];


    public static function setEnFonctionFiedToFalseExceptOne($id)
    {
        self::where('id', '!=', $id)->update(['en_fonction' => false]);
    }
}
