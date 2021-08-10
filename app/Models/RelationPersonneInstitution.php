<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelationPersonneInstitution extends Model
{
    use SoftDeletes;
    protected $table = 'zen_relation_personne_institution';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user', 'etablissement', 'type_relation', 'inscription'
    ];
}
