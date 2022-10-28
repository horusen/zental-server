<?php

namespace App\Models;

use App\Shared\Models\Fichier\Fichier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class President extends Model
{
    use SoftDeletes;
    protected $table = 'zen_president';
    protected $primaryKey = 'id';
    protected $fillable = ['prenom', 'inscription', 'nom', 'biographie', 'photo', 'pays'];
    protected $with = ['pays', 'photo'];
    protected $appends = ['nom_complet'];


    public function photo()
    {
      return $this->belongsTo(Fichier::class, 'photo');
    }

    public function pays()
    {
      return $this->belongsTo(Pays::class, 'pays');
    }


    public function getNomCompletAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }
}
