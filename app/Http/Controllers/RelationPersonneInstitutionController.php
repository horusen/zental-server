<?php

namespace App\Http\Controllers;

use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class RelationPersonneInstitutionController extends BaseController
{
    protected $model = RelationInterpersonnelle::class;
    protected $validation = [
        'type_relation' => 'required|integer|exists:zen_type_relation,id',
        'user' => 'required|integer|exist:cpt_inscription,id_inscription',
        'etablissement' => 'required|integer|exist:zen_entite_diplomatique,id',
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }
}
