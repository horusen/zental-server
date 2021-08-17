<?php

namespace App\Http\Controllers;

use App\Models\TypeRelation;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class TypeRelationController extends BaseController
{
    protected $model = TypeRelation::class;
    protected $validation = [
        'libelle' => 'required',
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }
}
