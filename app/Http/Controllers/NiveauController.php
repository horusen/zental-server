<?php

namespace App\Http\Controllers;

use App\Models\Niveau;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class NiveauController extends BaseController
{
    protected $model = Niveau::class;
    protected $validation = [
        'libelle' => 'required',
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }
}
