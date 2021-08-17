<?php

namespace App\Http\Controllers;

use App\Models\SituationMatrimoniale;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class SituationMatrimonialController extends BaseController
{
    protected $model = SituationMatrimoniale::class;
    protected $validation = [
        'libelle' => 'required'
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }
}
