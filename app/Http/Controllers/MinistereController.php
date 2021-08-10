<?php

namespace App\Http\Controllers;

use App\Models\EntiteDiplomatique;
use App\Models\Ministere;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MinistereController extends BaseController
{
    protected $model = Ministere::class;
    protected $validation = [
        'libelle' => 'required',
        'pays_origine' => 'required|integer|exists:pays,id',
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }

    public function getByCurrentUser()
    {
        return $this->model::where('inscription', Auth::id())->latest()->get();
    }


    public function store(Request $request)
    {
        $this->validate($request, $this->validation);
        $request['pays_siege'] = $request->pays_origine;
        $entiteDiplomatique = EntiteDiplomatique::add($request->all());
        $ambassade = $this->model::create(['entite_diplomatique' => $entiteDiplomatique->id, 'inscription' => Auth::id()]);
        return $this->model::findOrFail($ambassade->id);
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, $this->validation);
        $ambassade = $this->model::findOrFail($id);
        EntiteDiplomatique::edit($ambassade->entite_diplomatique, $request->all());
        return $this->model::findOrFail($id);
    }
}
