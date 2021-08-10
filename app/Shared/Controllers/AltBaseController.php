<?php

namespace App\Http\Controllers\Shared;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Formation;

class AltBaseController extends BaseController
{
    public function __construct()
    {
        parent::__construct(Formation::class, []);
    }
}
