<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembreGroupe extends Model
{
    use SoftDeletes;
    protected $table = 'zen_membre_groupe';
    protected $primaryKey = 'id';
    protected $fillable = ['membre', 'inscription', 'groupe', "admin"];
    protected $with = ['membre'];


    public function membre()
    {
        return $this->belongsTo(User::class, 'membre');
    }
}
