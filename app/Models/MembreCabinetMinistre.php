<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembreCabinetMinistre extends Model
{
    use SoftDeletes;
    protected $table = 'zen_membre_cabinet_ministre';
    protected $primaryKey = 'id';
    protected $fillable = [
        'membre', 'ministre', 'poste', 'fonction', 'inscription'
    ];

    protected $with = ['membre', 'poste', 'fonction'];


    public function membre()
    {
        return $this->belongsTo(User::class, 'membre');
    }

    public function ministre()
    {
        return $this->belongsTo(Ministre::class, 'ministre');
    }
    public function poste()
    {
        return $this->belongsTo(Poste::class, 'poste');
    }
    public function fonction()
    {
        return $this->belongsTo(Fonction::class, 'fonction');
    }
}
