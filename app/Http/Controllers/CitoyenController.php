<?php

namespace App\Http\Controllers;

use App\Shared\Controllers\BaseController;
use App\Traits\CitoyenTrait;
use App\User;

use Illuminate\Http\Request;

class CitoyenController extends BaseController
{
    use CitoyenTrait;

    protected $model = User::class;
    protected $validation = [
        'user' => 'required|integer|exists:cpt_inscription'
    ];


    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }

    public function getByLiaison(Request $request, $liaison)
    {
        $citoyens = $this->filterByLiaisons($this->modelQuery, [$liaison]);
        return $this->refineData($citoyens, $request)->latest()->get();
    }

    public function getByAmbassade(Request $request, $ambassade)
    {
        $citoyens = $this->filterByAmbassades($this->modelQuery, [$ambassade]);
        return $this->refineData($citoyens, $request)->latest()->get();
    }


    public function getByConsulat(Request $request, $consulat)
    {
        $citoyens = $this->filterByConsulats($this->modelQuery, [$consulat]);
        return $this->refineData($citoyens, $request)->get();
    }

    public function getByPays(Request $request, $pays)
    {
        $citoyens = $this->filterByPays($this->modelQuery, [$pays]);
        return $this->refineData($citoyens, $request)->get();
    }
}
