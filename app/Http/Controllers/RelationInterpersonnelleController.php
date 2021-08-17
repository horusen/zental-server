<?php

namespace App\Http\Controllers;

use App\Models\RelationInterpersonnelle;
use App\Shared\Controllers\BaseController;
use App\Traits\RelationInterpersonnelleTrait;
use Illuminate\Http\Request;

class RelationInterpersonnelleController extends BaseController
{
    use RelationInterpersonnelleTrait;
    protected $model = RelationInterpersonnelle::class;
    protected $validation = [
        'type_relation' => 'required|integer|exists:zen_type_relation,id',
        'user1' => 'required|integer|exists:cpt_inscription,id_inscription',
        'user2' => 'required|integer|exists:cpt_inscription,id_inscription',
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }


    public function getByUser(Request $request, $user)
    {
        $relations = $this->filterByUser($this->modelQuery, $user);
        return $this->refineData($relations, $request)->latest()->get();
    }
}
