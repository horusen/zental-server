<?php

namespace App\Http\Controllers\Shared;

use App\Models\Formation;
use App\Shared\Controllers\BaseController;

class AltBaseController extends BaseController
{
    public function __construct()
    {
        parent::__construct(Formation::class, []);
    }
}
