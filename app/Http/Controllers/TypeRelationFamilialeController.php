<?php

namespace App\Http\Controllers;

use App\Models\TypeRelationFamiliale;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class TypeRelationFamilialeController extends BaseController
{
    protected $model = TypeRelationFamiliale::class;
    protected $validation = [
        'libelle' => 'required',
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }
}
