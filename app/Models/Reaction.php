<?php

namespace App\Models;

use App\Shared\Models\Fichier\Fichier;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reaction extends Model
{
    use SoftDeletes;
    protected $table = 'zen_reaction';
    protected $primaryKey = 'id';
    protected $fillable = ['reaction', 'inscription', 'discussion', 'file', 'rebondissement'];
    protected $appends = ['user', 'service', 'institution'];
    protected $hidden = ['inscription'];
    protected $with = ['rebondissement', 'file'];

    public function discussion()
    {
        return $this->belongsTo(Discussion::class, 'discussion');
    }


    public function file()
    {
        return $this->belongsTo(Fichier::class, 'file');
    }

    public function rebondissement()
    {
        return $this->belongsTo(Reaction::class, 'rebondissement');
    }

    public function inscription()
    {
        return $this->belongsTo(User::class, 'inscription');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, AffectationReactionService::class, 'reaction', 'service');
    }

    public function ministeres()
    {
        return $this->belongsToMany(Ministere::class, AffectationReactionMinistere::class, 'reaction', 'ministere');
    }


    public function ambassades()
    {
        return $this->belongsToMany(Ambassade::class, AffectationReactionAmbassade::class, 'reaction', 'ambassade');
    }

    public function consulats()
    {
        return $this->belongsToMany(Consulat::class, AffectationReactionConsulat::class, 'reaction', 'consulat');
    }

    public function bureaux()
    {
        return $this->belongsToMany(Bureau::class, AffectationReactionBureau::class, 'reaction', 'bureau');
    }

    public function getServiceAttribute()
    {
        $service = $this->services()->get()->first();
        if (isset($service)) {
            return [
                'id' => $service->id,
                'libelle' => $service->libelle
            ];
        }

        return null;
    }

    public function getMinistereAttribute()
    {
        $ministere = $this->ministeres()->get()->first();
        return isset($ministere) ? $ministere : null;
    }


    public function getAmbassadeAttribute()
    {
        $ambassade = $this->ambassades()->get()->first();
        return isset($ambassade) ? $ambassade : null;
    }


    public function getConsulatAttribute()
    {
        $consulat = $this->consulats()->get()->first();
        return isset($consulat) ? $consulat : null;
    }


    public function getBureauAttribute()
    {
        $bureau = $this->bureaux()->get()->first();
        return isset($bureau) ? $bureau : null;
    }


    public function getUserAttribute()
    {
        return [
            'id_inscription' => $this->inscription()->get()->first()->id_inscription,
            'nom_complet' => $this->inscription()->get()->first()->nom_complet,
            'photo' => $this->inscription()->get()->first()->photo()->get()->first() ? $this->inscription()->get()->first()->photo()->get()->first()->path : null
        ];
    }


    public function getInstitutionAttribute()
    {
        $ministere = $this->getMinistereAttribute();
        if (isset($ministere)) {
            return [
                'type' => 'ministere',
                'institution' => $this->getMinistereAttribute()
            ];
        }


        $ambassade = $this->getAmbassadeAttribute();
        if (isset($ambassade)) {
            return [
                'type' => 'ambassade',
                'institution' => $this->getAmbassadeAttribute()
            ];
        }

        $consulat = $this->getConsulatAttribute();
        if (isset($consulat)) {
            return [
                'type' => 'consulat',
                'institution' => $this->getConsulatAttribute()
            ];
        }

        $bureau = $this->getBureauAttribute();
        if (isset($bureau)) {
            return [
                'type' => 'bureau',
                'institution' => $this->getBureauAttribute()
            ];
        }
    }
}
