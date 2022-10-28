<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DemandeAdhesion extends Model
{
    use SoftDeletes;
    protected $table = 'zen_demande_adhesion_groupe';
    protected $primaryKey = 'id';
    protected $fillable = ['user', 'inscription', 'groupe', 'validation'];
    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user');
    }
}
