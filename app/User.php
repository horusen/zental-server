<?php

namespace App;

use App\Models\Employe;
use App\Models\MembreCabinetMinistre;
use App\Models\Service;
use App\Shared\Models\Fichier\Fichier;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    protected $table = 'cpt_inscription';

    protected $primaryKey = 'id_inscription';

    public $timestamps = true;
    // protected $with = ['photo', 'photo_min'];
    protected $with = ['photo'];

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
}
