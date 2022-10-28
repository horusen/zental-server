<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CorrespondanceUtilisateurService extends Model
{
    use SoftDeletes;
    protected $table = 'zen_correspondance_utilisateur_service';
    protected $primaryKey = 'id';
    protected $fillable = ['discussion', 'inscription', 'user', 'service'];
    protected $appends = ['service_correspondant'];
    protected $hidden = ['service'];
    protected $with = ['user'];


    public function service()
    {
        return $this->belongsTo(Service::class, 'service');
    }


    public function getServiceCorrespondantAttribute()
    {
        return $this->service()->get()->first()->append(['institution']);
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user');
    }
}
