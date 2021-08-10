<?php

namespace App\Http\Controllers;

use App\Models\RelationInterpersonnelle;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class RelationInterpersonnelleController extends BaseController
{
    protected $model = RelationInterpersonnelle::class;
    protected $validation = [
        'type_relation' => 'required|integer|exists:zen_type_relation,id',
        'user1' => 'required|integer|exist:cpt_inscription,id_inscription',
        'user2' => 'required|integer|exist:cpt_inscription,id_inscription',
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }
}
