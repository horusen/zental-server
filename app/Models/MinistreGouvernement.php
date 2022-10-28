<?php

namespace App\Models;

use App\Shared\Models\Fichier\Fichier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MinistreGouvernement extends Model
{
    use SoftDeletes;
    protected $table = 'zen_ministre_gouvernement';
    protected $primaryKey = 'id';
    protected $fillable = ['prenom', 'inscription', 'nom', 'ministere', 'pays', 'photo'];

    protected $appends = ['nom_complet'];
    protected $with = ['photo'];


    public function photo()
    {
      return $this->belongsTo(Fichier::class, 'photo');
    }


    public function getNomCompletAttribute(){
      return $this->prenom . ' ' . $this->nom;
    }
}
