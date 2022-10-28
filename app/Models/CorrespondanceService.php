<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CorrespondanceService extends Model
{
    use SoftDeletes;
    protected $table = 'zen_correspondance_service';
    protected $primaryKey = 'id';
    protected $fillable = ['service1', 'inscription', 'service2', 'discussion'];
    // protected $with = ['service1', 'service2'];
    protected $appends = ['service_correspondant1', 'service_correspondant2'];
    protected $hidden = ['service1', 'service2'];

    public function service1()
    {
        return $this->belongsTo(Service::class, 'service1');
    }

    public function service2()
    {
        return $this->belongsTo(Service::class, 'service2');
    }

    public function getServiceCorrespondant1Attribute()
    {
        return $this->service1()->get()->first()->append(['institution']);
    }

    public function getServiceCorrespondant2Attribute()
    {
        return $this->service2()->get()->first()->append(['institution']);
    }
}
