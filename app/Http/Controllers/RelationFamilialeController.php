<?php

namespace App\Http\Controllers;

use App\Models\RelationFamiliale;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class RelationFamilialeController extends BaseController
{
    protected $model = RelationFamiliale::class;
    protected $validation = [
        'type' => 'required|integer|exists:zen_type_relation_familiale,id',
        'user' => 'required|integer|exists:cpt_inscription,id_inscription',
        'membre_famille' => 'required|integer|exists:cpt_inscription,id_inscription'
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }


    public function getByUserAndByType($user, $type)
    {
        return $this->model::whereHas('type', function ($q) use ($type) {
            $q->where('libelle', $type);
        })->where('user', $user)->first();
    }


    public function getByUserAndByTypeList($user, $type)
    {
        return $this->model::whereHas('type', function ($q) use ($type) {
            $q->where('libelle', $type);
        })->where('user', $user)->get();
    }
}
