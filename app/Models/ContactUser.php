<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactUser extends Model
{
    use SoftDeletes;
    protected $table = 'zen_contact_user';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user', 'contact', 'inscription', 'type_contact', 'urgence'
    ];
}
