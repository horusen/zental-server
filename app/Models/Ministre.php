<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ministre extends Model
{
    use SoftDeletes;
    protected $table = 'zen_ministre';
    protected $primaryKey = 'id';
    protected $fillable = [
        'ministre', 'debut_fonction', 'fin_fonction', 'biographie', 'en_fonction', 'ministere', 'inscription'
    ];

    protected $with = ['ministre.photo'];


    public function ministre()
    {
        return $this->belongsTo(User::class, 'ministre');
    }

    public function ministere()
    {
        return $this->belongsTo(Ministere::class, 'ministere');
    }
}
