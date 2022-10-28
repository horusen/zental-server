<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Passerelle extends Model
{
    use SoftDeletes;
    protected $table = 'zen_passerelle';
    protected $primaryKey = 'id';
    protected $fillable = ['pays_origine', 'pays_siege', 'inscription', 'passe_frontiere', 'type'];
    protected $with = ['pays_origine', 'pays_siege', 'type', 'passe_frontiere'];
    protected $append = ['bureau'];




    public function type()
    {
        return $this->belongsTo(TypePasserelle::class, 'type');
    }

    public function pays_origine()
    {
        return $this->belongsTo(Pays::class, 'pays_origine');
    }

    public function pays_siege()
    {
        return $this->belongsTo(Pays::class, 'pays_siege');
    }


    public function passe_frontiere()
    {
        return $this->belongsTo(PasseFrontiere::class, 'passe_frontiere');
    }

    public function bureaux()
    {
        return $this->belongsToMany(Bureau::class, AffectationBureauPasserelle::class, 'passerelle', 'bureau')->wherePivotNull('deleted_at');
    }

    public function getBureauAttribute()
    {
        return $this->bureaux()->get()->first();
    }
}
