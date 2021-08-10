<?php

namespace App\Http\Controllers;

use App\Shared\Controllers\BaseController;
use App\Traits\UserTrait;
use App\User;

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

    public function getNonEmployesDansService($service)
    {
        return $this->filterByNonEmployesDansServices($this->modelQuery, [$service])->latest()->get();
    }
}
