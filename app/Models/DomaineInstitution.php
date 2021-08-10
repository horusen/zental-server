<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DomaineInstitution extends Model
{
    use SoftDeletes;
    protected $table = 'zen_domaine_institution';
    protected $primaryKey = 'id';
    protected $fillable = [
        'libelle', 'description', 'inscription'
    ];
}
