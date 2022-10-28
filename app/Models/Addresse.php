<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Addresse extends Model
{
    use SoftDeletes;
    protected $table = 'zen_adresse';
    protected $primaryKey = 'id';
    protected $fillable = [
        'ville', 'addresse', 'inscription'
    ];

    protected $with = ['ville.pays'];

    public function ville()
    {
        return $this->belongsTo(Ville::class, 'ville');
    }


    public function entite_diplomatiques()
    {
        return $this->belongsToMany(EntiteDiplomatique::class, AffectationAdresseEntiteDiplomatique::class, 'addresse', 'entite_diplomatique');
    }


    public function user()
    {
        return $this->hasOne(User::class, 'addresse');
    }
}
