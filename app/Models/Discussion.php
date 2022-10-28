<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Discussion extends Model
{
    use SoftDeletes;
    protected $table = 'zen_discussion';
    protected $primaryKey = 'id';
    protected $fillable = ['type', 'inscription', 'inscription', 'touched_at'];
    protected $appends = ['correspondance', 'last_reaction'];


    public function correspondance_utilisateur()
    {
        return $this->hasOne(CorrespondanceUtilisateur::class, 'discussion');
    }

    public function correspondance_service()
    {
        return $this->hasOne(CorrespondanceService::class, 'discussion');
    }

    public function correspondance_groupe()
    {
        return $this->hasOne(CorrespondanceGroupe::class, 'discussion');
    }


    public function getLastReactionAttribute()
    {
        return $this->reactions()->latest()->first();
    }

    public function correspondance_utilisateur_service()
    {
        return $this->hasOne(CorrespondanceUtilisateurService::class, 'discussion');
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class, 'discussion');
    }

    public function getCorrespondanceAttribute()
    {
        switch ($this->type) {
            case 1:
                return $this->correspondance_utilisateur()->get()->first();
            case 2:
                return $this->correspondance_utilisateur_service()->get()->first();

            case 3:
                return $this->correspondance_groupe()->get()->first();

            case 4:
                return $this->correspondance_service()->get()->first();
        }

        return null;
    }
}
