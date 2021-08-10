<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AffectationAmbassadeurAmbassade extends Model
{
    use SoftDeletes;
    protected $table = 'zen_affectation_ambassadeur_ambassade';
    protected $primaryKey = 'id';
    protected $fillable = [
        'ambassade', 'ambassadeur', 'inscription', 'en_fonction'
    ];


    public static function setEnFonctionFiedToFalseExceptOne($id)
    {
        self::where('id', '!=', $id)->update(['en_fonction' => false]);
    }
}
