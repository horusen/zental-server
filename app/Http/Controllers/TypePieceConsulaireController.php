<?php

namespace App\Http\Controllers;

use App\Shared\Controllers\BaseController;
use App\TypePieceConsulaire;
use Illuminate\Http\Request;

class TypePieceConsulaireController extends BaseController
{
    protected $model = TypePieceConsulaire::class;
    protected $validation = [
        'libelle' => 'required'
    ];


    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }
}
