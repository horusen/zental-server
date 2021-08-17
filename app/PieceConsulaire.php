<?php

namespace App;

use App\Shared\Models\Fichier\Fichier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PieceConsulaire extends Model
{
    use SoftDeletes;
    protected $table = 'zen_piece_consulaire';
    protected $primaryKey = 'id';
    protected $fillable = ['user', 'type', 'debut', 'fin', 'fichier_joint', 'inscription', 'note'];
    protected $with = ['fichier_joint'];



    public function fichier_joint()
    {
        return $this->belongsTo(Fichier::class, 'fichier_joint');
    }


    public function type()
    {
        return $this->belongsTo(TypePieceConsulaire::class, 'type');
    }
}
