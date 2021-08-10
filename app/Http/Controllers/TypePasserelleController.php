<?php

namespace App\Http\Controllers;

use App\Models\TypePasserelle;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class TypePasserelleController extends BaseController
{
    protected $model = TypePasserelle::class;
    protected $validation = [
        'libelle' => 'required',
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }
}
