<?php

namespace App\Http\Controllers;

use App\Models\Emploie;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class EmploieController extends BaseController
{
    protected $model = Emploie::class;
    protected $validation = [
        'domaine' => 'required|integer|exists:zen_domaine,id',
        'type_contrat' => 'required|integer|exists:zen_type_contrat,id',
        'user' => 'required|integer|exist:cpt_inscription,id_inscription',
        'debut' => 'date',
        'fin' => 'date',
        'etablissement' => 'required'
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }
}
