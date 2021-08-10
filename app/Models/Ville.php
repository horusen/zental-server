<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    protected $table = 'ville';

    protected $primaryKey = 'id_ville';

    public $timestamps = false;

    protected $guarded = ['id'];

    public function pays()
    {
        return $this->belongsTo(Pays::class, 'pays');
    }
}
