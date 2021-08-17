<?php

namespace App\Http\Controllers;

use App\Models\TypeContact;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class TypeContactController extends BaseController
{
    protected $model = TypeContact::class;
    protected $validation = [
        'libelle' => 'required',
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }
}
