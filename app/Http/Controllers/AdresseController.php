<?php

namespace App\Http\Controllers;

use App\Models\Adresse;
use App\Models\AffectationAdresseEntiteDiplomatique;
use App\Models\AffectationAdresseMinistere;
use App\Shared\Controllers\BaseController;
use App\Traits\AdresseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdresseController extends BaseController
{
    use AdresseTrait;
    protected $model = Adresse::class;
    protected $validation = [
        'ville' => 'required|integer|exists:ville,id_ville',
        'entite_diplomatique' => 'required|integer|exists:zen_entite_diplomatique,id',
        'adresse' => 'required',
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }

    public function store(Request $request)
    {
        $validated = $this->isValid($request);
        $adresse = $this->model::create(array_merge($validated, ['inscription' => Auth::id()]));

        AffectationAdresseEntiteDiplomatique::create(['entite_diplomatique' => $request->entite_diplomatique, 'addresse' => $adresse->id, 'inscription' => Auth::id()]);
        return $this->model::find($adresse->id);
    }


    public function update(Request $request, $id)
    {
        $this->isValid($request);

        $adresse = $this->model::findOrFail($id);
        $adresse->delete();
        return $this->store($request);
    }


    public function getByMinistere($ministere)
    {
        return $this->filterByMinisteres($this->modelQuery, [$ministere])->latest()->get();
    }


    public function getByAmbassade($ambassade)
    {
        return $this->filterByAmbassades($this->modelQuery, [$ambassade])->latest()->get();
    }


    public function getByConsulat($consulat)
    {
        return $this->filterByConsulats($this->modelQuery, [$consulat])->latest()->get();
    }
}
