<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationMinistreMinistere extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_ministre_ministere';
    protected $primaryKey = 'id';
    protected $fillable = [
        'ministere', 'ministre', 'inscription', 'en_fonction'
    ];


    public static function setEnFonctionFiedToFalseExceptOne($id)
    {
        self::where('id', '!=', $id)->update(['en_fonction' => false]);
    }
}
