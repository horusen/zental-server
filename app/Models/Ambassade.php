<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ambassade extends Model
{
    use SoftDeletes;
    protected $table = 'zen_ambassade';
    protected $primaryKey = 'id';
    protected $fillable = ['entite_diplomatique', 'inscription'];
    protected $with = ['entite_diplomatique.pays_siege'];

    public function entite_diplomatique()
    {
        return $this->belongsTo(EntiteDiplomatique::class, 'entite_diplomatique');
    }
}
