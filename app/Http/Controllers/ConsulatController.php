<?php

namespace App\Http\Controllers;

use App\Models\AffectationConsulatAmbassade;
use App\Models\AffectationConsulatMinistere;
use App\Models\Consulat;
use App\Models\EntiteDiplomatique;
use App\Shared\Controllers\BaseController;
use App\Traits\ConsulatTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsulatController extends BaseController
{
    use ConsulatTrait;
    protected $model = Consulat::class;
    protected $validation = [
        'libelle' => 'required',
        'pays_origine' => 'ville|integer|exists:ville,id_ville',
        'pays_origine' => 'required|integer|exists:pays,id',
        'pays_siege' => 'required|integer|exists:pays,id',
        'description' => '',
        'ministere' => 'required_without:ambassade|integer|exists:zen_ministere,id',
        'ambassade' => 'required_without:ministere|integer|exists:zen_ambassade,id'

    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }


    public function getByMinistere(Request $request, $ministere)
    {
        $consulats = $this->filterByMinisteres($this->modelQuery, [$ministere]);
        return $this->refineData($consulats, $request)->latest()->get();
    }


    public function getByAmbassade(Request $request, $ambassade)
    {
        $consulats = $this->filterByAmbassades($this->modelQuery, [$ambassade]);
        return $this->refineData($consulats, $request)->latest()->get();
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, $this->validation);
        $entiteDiplomatique = EntiteDiplomatique::add($validated);
        $consulat = $this->model::create(['entite_diplomatique' => $entiteDiplomatique->id, 'inscription' => Auth::id()]);

        if ($request->has('ministere')) {

            AffectationConsulatMinistere::create(['ministere' => $request->ministere, 'consulat' => $consulat->id, 'inscription' => Auth::id()]);
        } else  if ($request->has('ambassade')) {

            AffectationConsulatAmbassade::create(['ambassade' => $request->ambassade, 'consulat' => $consulat->id, 'inscription' => Auth::id()]);
        }


        return $this->model::find($consulat->id);
    }


    public function update(Request $request, $id)
    {
        $validated = $this->validate($request, $this->validation);
        $consulat = $this->model::findOrFail($id);
        EntiteDiplomatique::edit($consulat->entite_diplomatique, $validated);
        $consulat->update($validated);
        return $this->model::findOrFail($id);
    }
}
