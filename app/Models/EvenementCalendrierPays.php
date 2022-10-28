<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EvenementCalendrierPays extends Model
{
    use SoftDeletes;
    protected $table = 'zen_evenement_calendrier_pays';
    protected $primaryKey = 'id';
    protected $fillable = ['libelle', 'inscription', 'description', 'date', 'pays'];
}
