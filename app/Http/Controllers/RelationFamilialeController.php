<?php

namespace App\Http\Controllers;

use App\Models\Famille;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class FamilleController extends BaseController
{
    protected $model = Famille::class;
    protected $validation = [
        'type' => 'required|integer|exists:zen_type_relation_familiale,id',
        'user' => 'required|integer|exist:cpt_inscription,id_inscription',
        'membre_famille' => 'required|integer|exist:cpt_inscription,id_inscription'
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }
}
