<?php

namespace App\Http\Controllers;

use App\Models\PasseFrontiere;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class PasseFrontiereController extends BaseController
{
    protected $model = PasseFrontiere::class;
    protected $validation = [
        'libelle' => 'required',
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }
}
