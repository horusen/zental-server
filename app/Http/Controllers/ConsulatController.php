<?php

namespace App\Http\Controllers;

use App\Models\Addresse;
use App\Models\AffectationAdresseEntiteDiplomatique;
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
        'ville' => 'required|integer|exists:ville,id_ville',
        'addresse' => 'required',
        'pays_origine' => 'required|integer|exists:pays,id',
        'pays_siege' => 'required|integer|exists:pays,id',
        'description' => '',

    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }


    public function getAllData(Request $request)
    {
        return $this->refineData($this->modelQuery, $request)->latest()->get();
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


    public function getByUser(Request $request, $user)
    {
        $consulats = $this->filterByUser($this->modelQuery, $user);
        return $this->refineData($consulats, $request)->latest()->get();
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validation + [
            'ministere' => 'required_without:ambassade|integer|exists:zen_ministere,id',
            'ambassade' => 'required_without:ministere|integer|exists:zen_ambassade,id'
        ]);


        $entiteDiplomatique = EntiteDiplomatique::add($request->all());
        $consulat = $this->model::create(['entite_diplomatique' => $entiteDiplomatique->id, 'inscription' => Auth::id()]);


        $addresse = Addresse::create($request->only(['addresse', 'ville']) + ['inscription' => Auth::id()]);
        AffectationAdresseEntiteDiplomatique::create(['entite_diplomatique' => $entiteDiplomatique->id, 'addresse' => $addresse->id, 'inscription' => Auth::id()]);

        if ($request->has('ministere')) {

            AffectationConsulatMinistere::create(['ministere' => $request->ministere, 'consulat' => $consulat->id, 'inscription' => Auth::id()]);
        } else  if ($request->has('ambassade')) {

            AffectationConsulatAmbassade::create(['ambassade' => $request->ambassade, 'consulat' => $consulat->id, 'inscription' => Auth::id()]);
        }


        return $this->model::find($consulat->id);
    }


    public function update(Request $request, $id)
    {
        // Request validations
        $this->validate($request, $this->validation);

        // Get consulat
        $consulat = $this->model::findOrFail($id);

        // Update entite_diplomatique
        EntiteDiplomatique::edit($consulat->entite_diplomatique, $request->all());

        // Update addresse
        $addresse = $consulat->entite_diplomatique()->get()->first()->addresses->first();
        $addresse->update($request->only(['addresse', 'ville']));

        // Return response
        return $this->model::findOrFail($id);
    }


    public function getByPays(Request $request, $pays)
    {
        $consulats = $this->filterByPays($this->modelQuery, [$pays]);
        return $this->refineData($consulats, $request)->get();
    }
}
