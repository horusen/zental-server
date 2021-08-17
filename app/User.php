<?php

namespace App;

use App\Http\Controllers\RelationInterpersonnelleController;
use App\Models\ContactUser;
use App\Models\Employe;
use App\Models\MembreCabinetMinistre;
use App\Models\RelationFamiliale;
use App\Models\RelationInterpersonnelle;
use App\Models\Service;
use App\Models\SituationMatrimoniale;
use App\Models\Ville;
use App\Shared\Models\Fichier\Fichier;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;
    use \Awobaz\Compoships\Compoships;

    protected $table = 'cpt_inscription';

    protected $primaryKey = 'id_inscription';

    public $timestamps = true;
    // protected $with = ['photo', 'photo_min'];
    protected $with = ['photo', 'lieu_naissance.pays', 'situation_matrimoniale'];

    protected $guarded = ['id_inscription'];
    protected $appends = ['nom_complet'];



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
