<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CorrespondanceGroupe extends Model
{
    use SoftDeletes;
    protected $table = 'zen_correspondance_groupe';
    protected $primaryKey = 'id';
    protected $fillable = ['groupe', 'inscription', 'discussion'];
    protected $with = ['groupe'];


    public function groupe()
    {
        return $this->belongsTo(Groupe::class, 'groupe');
    }

    public function discussion()
    {
        return $this->belongsTo(Discussion::class, 'discussion');
    }
}
