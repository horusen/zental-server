<?php

namespace App\Http\Controllers;

use App\Models\TypeContrat;
use App\Shared\Controllers\BaseController;

class TypeContratController extends BaseController
{
    protected $model = TypeContrat::class;
    protected $validation = [
        'libelle' => 'required',
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }
}
