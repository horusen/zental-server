<?php

namespace App\Http\Controllers;

use App\Models\AffectationAmbassadeMinistere;
use App\Models\Ambassade;
use App\Models\EntiteDiplomatique;
use App\Shared\Controllers\BaseController;
use App\Traits\AmbassadeTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AmbassadeController extends BaseController
{
    use AmbassadeTrait;
    protected $model = Ambassade::class;
    protected $validation = [
        'libelle' => 'required',
        'pays_origine' => 'required|integer|exists:pays,id',
        'pays_siege' => 'required|integer|exists:pays,id',
        'description' => ''
    ];


    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }

    public function getByPays(Request $request, $pays)
    {
        $ambassades = $this->filterByPays($this->modelQuery, [$pays]);
        return $this->refineData($ambassades, $request)->get();
    }


    public function getByUser(Request $request, $user)
    {
        $ambassades = $this->filterByUser($this->modelQuery, $user);
        return $this->refineData($ambassades, $request)->latest()->get();
    }

    public function getAllData(Request $request)
    {
        return $this->refineData($this->modelQuery, $request)->latest()->get();
    }

    public function getByMinistere(Request $request, $ministere)
    {
        $ambassades = $this->filterByMinisteres($this->modelQuery, [$ministere]);
        return $this->refineData($ambassades, $request)->get();
    }


    public function store(Request $request)
    {
        $this->validate($request, $this->validation);
        $entiteDiplomatique = EntiteDiplomatique::add($request->all());
        $ambassade = $this->model::create(['entite_diplomatique' => $entiteDiplomatique->id, 'inscription' => Auth::id()]);

        if ($request->has('ministere')) {
            AffectationAmbassadeMinistere::create(['ambassade' => $ambassade->id, 'ministere' => $request->ministere, 'inscription' => Auth::id()]);
        }

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
