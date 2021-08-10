<?php

namespace App\Http\Controllers;

use App\Models\Diplome;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class DiplomeController extends BaseController
{
    protected $model = Diplome::class;
    protected $validation = [
        'domaine' => 'required|integer|exists:zen_domaine,id',
        'niveau' => 'required|integer|exists:zen_niveau,id',
        'user' => 'required|integer|exist:cpt_inscription,id_inscription',
        'annee_obtention' => 'date',
        'etablissement' => 'required'
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }
}
