<?php

namespace App;

use App\Http\Controllers\RelationInterpersonnelleController;
use App\Models\Addresse;
use App\Models\ContactUser;
use App\Models\Employe;
use App\Models\InscriptionConsulaire;
use App\Models\Liaison;
use App\Models\MembreCabinetMinistre;
use App\Models\MembreGroupe;
use App\Models\Nationalite;
use App\Models\RelationFamiliale;
use App\Models\RelationInterpersonnelle;
use App\Models\Service;
use App\Models\SituationMatrimoniale;
use App\Models\Ville;
use App\Shared\Models\Fichier\Fichier;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;
    use \Awobaz\Compoships\Compoships;

    protected $table = 'cpt_inscription';

    protected $primaryKey = 'id_inscription';

    public $timestamps = true;
    // protected $with = ['photo', 'photo_min'];
    protected $with = ['photo', 'lieu_naissance.pays', 'situation_matrimoniale', 'addresse.ville.pays'];

    protected $fillable = ['id_cam', 'identifiant', 'nom', 'prenom', 'date_naissance', 'lieu_naissance', 'email', 'password', 'sexe', 'email_recuperation', 'tel_recuperation', 'active', 'telephone', 'slug', 'photo', 'photo_min', 'situation_matrimoniale', 'profession', 'addresse'];

    protected $appends = ['nom_complet'];


    public function addresse()
    {
        return $this->belongsTo(Addresse::class, 'addresse')->whereNull('deleted_at');
    }

    public function membership_groupe()
    {
        return $this->hasMany(MembreGroupe::class, 'membre');
    }

    public function photo()
    {
        return $this->belongsTo(Fichier::class, 'photo');
    }
    public function photo_min()
    {
        return $this->belongsTo(Fichier::class, 'photo_min');
    }

    public function membresCabinetMinistre()
    {
        return $this->hasMany(MembreCabinetMinistre::class, 'membre');
    }


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getNomCompletAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }


    // public function setPasswordAttibute($value)
    // {
    //     $this->attributes['password'] = Hash::make($value);
    // }

    public function nationalites()
    {
        return $this->hasMany(Nationalite::class, 'user');
    }

    private function inscriptionConsulaires()
    {
        return $this->hasMany(InscriptionConsulaire::class, 'user');
    }

    public function getInscriptionConsulaireAttribute()
    {
        $inscription_consulaire = $this->inscriptionConsulaires()->whereIn('etat', [2])->whereNull('deleted_at')->latest()->get()->first();
        $appendable = "";
        if (isset($inscription_consulaire)) {
            switch ($inscription_consulaire->type_entite_diplomatique) {
                case 1:
                    $appendable = 'ambassade';
                    break;
                case 2:
                    $appendable = 'consulat';
                    break;
                case 3:
                    $appendable = 'liaison';
                    break;
            }
        }
        return isset($inscription_consulaire) ? $inscription_consulaire->append([$appendable]) : null;
    }

    // public function test() {
    //     return Model::
    // }


    public function estCitoyens()
    {
        return $this->inscriptionConsulaires()->whereIn('etat', [2])->whereNull('deleted_at');
    }






    // TOus les employés sauf les ministeres, les consules et les ambassadeurs
    public function employes()
    {
        return $this->hasMany(Employe::class, 'employe')->whereNotIn('poste', [1, 2, 3]);
    }


    public function situation_matrimoniale()
    {
        return $this->belongsTo(SituationMatrimoniale::class, 'situation_matrimoniale');
    }


    public function lieu_naissance()
    {
        return $this->belongsTo(Ville::class, 'lieu_naissance');
    }


    public function relations_familiales()
    {
        return $this->hasMany(RelationFamiliale::class,  'membre_famille', 'id_inscription');
    }


    public function relations_interpersonnelles()
    {
        return $this->hasMany(RelationInterpersonnelle::class, ['user1', 'user2'], ['id_inscription', 'id_inscription']);
    }


    public function contacts()
    {
        return $this->hasMany(ContactUser::class, 'contact');
    }
}
