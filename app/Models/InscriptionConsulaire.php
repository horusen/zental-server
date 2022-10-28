<?php

namespace App\Models;

use App\Shared\Models\Fichier\Fichier;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InscriptionConsulaire extends Model
{
    use SoftDeletes;
    protected $table = 'zen_inscription_consulaire';
    protected $primaryKey = 'id';
    protected $fillable = ['user', 'justificatif_residence', 'etat', 'inscription', 'type_entite_diplomatique'];


    public function user()
    {
        return $this->belongsTo(User::class, 'user');
    }

    public function justificatif_residence()
    {
        return $this->belongsTo(Fichier::class, 'justificatif_residence');
    }

    public function type_entite_diplomatique()
    {
        return $this->belongsTo(TypeEntiteDiplomatique::class, 'type_entite_diplomatique');
    }

    public function etat()
    {
        return $this->belongsTo(EtatInscriptionConsulaire::class, 'etat');
    }

    public function motif_refus()
    {
        return $this->hasOne(MotifRefusInscriptionConsulaire::class, 'gglaire');
    }


    public function liaisons()
    {
        return $this->belongsToMany(Liaison::class, AffectationInscriptionConsulaireLiaison::class, 'inscription_consulaire', 'liaison');
    }


    public function ambassades()
    {
        return $this->belongsToMany(Ambassade::class, AffectationInscriptionConsulaireAmbassade::class, 'inscription_consulaire', 'ambassade');
    }

    public function consulats()
    {
        return $this->belongsToMany(Consulat::class, AffectationInscriptionConsulaireConsulat::class, 'inscription_consulaire', 'consulat');
    }

    public function getAmbassadeAttribute()
    {
        return $this->ambassades()->get()->first();
    }

    public function getConsulatAttribute()
    {
        return $this->consulats()->get()->first();
    }

    public function getLiaisonAttribute()
    {
        return $this->liaisons()->get()->first();
    }
}
