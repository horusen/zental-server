<?php

namespace App\Http\Controllers;

use App\Models\Domaine;
use App\Shared\Controllers\BaseController;


class DomaineController extends BaseController
{
    protected $model = Domaine::class;
    protected $validation = [
        'libelle' => 'required',
        'ministere' => 'required_without:ambassade|integer|exists:zen_ministere,id',
        'ambassade' => 'required_without:ministere|integer|exists:zen_ambassade,id'
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }
}
