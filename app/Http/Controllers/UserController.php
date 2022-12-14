<?php

namespace App\Http\Controllers;

use App\Shared\Controllers\BaseController;
use App\Traits\UserTrait;
use App\User;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    use UserTrait;

    protected $model = User::class;
    protected $validation = [
        // 'inscription' => 'required|numeric|exists:cpt_inscription,coursid_inscription',
        // 'libelle' => 'required',
        // 'domaine' => 'required|integer|exist:exp_domaine,id',

    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }

    public function getMembreFamilleByTypeRelationFamiliale($user, $type_relation_familiale)
    {
        return $this->filterMembreFamilleByTypeRelationFamiliale($this->modelQuery, $user, $type_relation_familiale)->first();
    }


    public function getByNonRelation($user)
    {
        return $this->filterByNonRelation($this->modelQuery, $user)->get();
    }

    public function getByNonContact($user)
    {
        return $this->filterByNonContact($this->modelQuery, $user)->get();
    }

    public function getNonEmployesDansService($service)
    {
        return $this->filterByNonEmployesDansServices($this->modelQuery, [$service])->latest()->get();
    }


    public function getNonMembresFamilles($user)
    {
        return $this->filterByNonMembresFamilles($this->modelQuery, $user)->latest()->get();
    }
}
