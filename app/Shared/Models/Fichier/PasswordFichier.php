<?php

namespace App\Shared\Models\Fichier;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PasswordFichier extends Model
{
    use SoftDeletes;
    protected $table = 'exp_password_fichier';
    protected $primaryKey = 'id';
    protected $fillable = ['fichier', 'inscription', 'password'];
}
