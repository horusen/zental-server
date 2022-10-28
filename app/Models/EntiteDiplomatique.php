<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EntiteDiplomatique extends Model
{
    use \Awobaz\Compoships\Compoships;
    protected $table = 'zen_entite_diplomatique';
    protected $primaryKey = 'id';
    protected $fillable = [
        'libelle', 'histoire', 'pays_origine', 'pays_siege', 'inscription', 'date_creation', 'devise', 'site_web', 'mail',
        'tel1', 'tel2', 'histoire', 'organisation', 'mission', 'boite_postale'
    ];

    public function pays_origine()
    {
        return $this->belongsTo(Pays::class, 'pays_origine');
    }

    public function pays_siege()
    {
        return $this->belongsTo(Pays::class, 'pays_siege');
    }

    public function addresses()
    {
        return $this->belongsToMany(Addresse::class, AffectationAdresseEntiteDiplomatique::class, 'entite_diplomatique', 'addresse');
    }

    public static function add(array $data)
    {
        return self::create(array_merge($data, ['inscription' => Auth::id()]));
    }

    public static function edit(int $id, array $data)
    {
        $entite = self::findOrFail($id);
        return $entite->update($data);
    }


    public function bureau()
    {
        return $this->hasOne(Bureau::class, 'entite_diplomatique');
    }

    public function ministere()
    {
        return $this->hasOne(Ministere::class, 'entite_diplomatique');
    }


    public function ambassade()
    {
        return $this->hasOne(Ambassade::class, 'entite_diplomatique');
    }


    public function consulat()
    {
        return $this->hasOne(Consulat::class, 'entite_diplomatique');
    }
}
