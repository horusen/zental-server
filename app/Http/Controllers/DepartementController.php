<?php

namespace App\Http\Controllers;

use App\Models\AffectationDepartementAmbassade;
use App\Models\AffectationDepartementMinistere;
use App\Models\Departement;
use App\Shared\Controllers\BaseController;
use App\Traits\DepartementTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartementController extends BaseController
{
    use DepartementTrait;
    protected $model = Departement::class;
    protected $validation = [
        'libelle' => 'required',
        'ministere' => 'required_without:ambassade|integer|exists:zen_ministere,id',
        'ambassade' => 'required_without:ministere|integer|exists:zen_ambassade,id'
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }

    public function store(Request $request)
    {
        $this->isValid($request, $this->validation);

        $departement = Departement::create(array_merge($request->all(), ['inscription' => Auth::id()]));

        if ($request->has('ministere')) {
            AffectationDepartementMinistere::create(['departement' => $departement->id, 'ministere' => $request->ministere, 'inscription' => Auth::id()]);
        } else if ($request->has('ambassade')) {
            AffectationDepartementAmbassade::create(['departement' => $departement->id, 'ambassade' => $request->ambassade, 'inscription' => Auth::id()]);
        }

        return $departement;
    }

    public function getByAmbassade(Request $request, $ambassade)
    {
        $departements = $this->model::whereHas('ambassades', function ($q) use ($ambassade) {
            $q->where('zen_ambassade.id', $ambassade);
        });

        return $this->refineData($departements, $request)->latest()->get();
    }


    public function getByDomaine(Request $request, $domaine)
    {
        $departements = $this->filterByDomaines($this->modelQuery, [$domaine]);
        return $this->refineData($departements, $request)->latest()->get();
    }


    public function getByMinistere(Request $request, $ministere)
    {
        $departements = $this->model::whereHas('ministeres', function ($q) use ($ministere) {
            $q->where('zen_ministere.id', $ministere);
        });

        return $this->refineData($departements, $request)->latest()->get();
    }
}
