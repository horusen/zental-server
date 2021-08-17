<?php

namespace App\Models;

use App\User;
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

    protected $with = ['type_contact', 'contact'];



    public function user()
    {
        return $this->belongsTo(User::class, 'user');
    }


    public function contact()
    {
        return $this->belongsTo(User::class, 'contact');
    }


    public function type_contact()
    {
        return $this->belongsTo(TypeContact::class, 'type_contact');
    }
}
