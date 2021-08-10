<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pays extends Model
{
    protected $table = 'pays';
    protected $primaryKey = 'id';
    public $timestamps = false;



    public function  entite_diplomatiques()
    {
        return $this->hasMany(EntiteDiplomatique::class, 'pays_origine');
    }
}
