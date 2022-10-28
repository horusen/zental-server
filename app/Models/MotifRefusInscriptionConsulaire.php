<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MotifRefusInscriptionConsulaire extends Model
{
    use SoftDeletes;
    protected $table = 'zen_motif_refus_inscription_consulaire';
    protected $primaryKey = 'id';
    protected $fillable = ['inscription_consulaire', 'description', 'inscription'];

    public function inscription_consulaire()
    {
        return $this->belongsTo(InscriptionConsulaire::class, 'inscription_consulaire');
    }
}
