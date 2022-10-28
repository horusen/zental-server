<?php

namespace App\Http\Controllers;

use App\Models\AffectationDomaineAmbassade;
use App\Models\AffectationDomaineBureau;
use App\Models\AffectationDomaineConsulat;
use App\Models\AffectationDomaineMinistere;
use App\Models\DomaineInstitution;
use App\Shared\Controllers\BaseController;
use App\Traits\DomaineInstitutionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DomaineInstitutionController extends BaseController
{
    use DomaineInstitutionTrait;
    protected $model = DomaineInstitution::class;
    protected $validation = [
        'libelle' => 'required',
        'ministere' => 'required_without_all:ambassade,consulat,bureau|integer|exists:zen_ministere,id',
        'ambassade' => 'required_without_all:ministere,consulat,bureau|integer|exists:zen_ambassade,id',
        'consulat' => 'required_without_all:ministere,ambassade,bureau|integer|exists:zen_consulat,id',
        'bureau' => 'required_without_all:ministere,ambassade,consulat|integer|exists:zen_bureau,id'
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }

    public function store(Request $request)
    {
        $this->isValid($request, $this->validation);

        $domaine = $this->model::create(array_merge($request->all(), ['inscription' => Auth::id()]));

        if ($request->has('ministere')) {
            AffectationDomaineMinistere::create(['domaine' => $domaine->id, 'ministere' => $request->ministere, 'inscription' => Auth::id()]);
        } else if ($request->has('ambassade')) {
            AffectationDomaineAmbassade::create(['domaine' => $domaine->id, 'ambassade' => $request->ambassade, 'inscription' => Auth::id()]);
        } else if ($request->has('consulat')) {
            AffectationDomaineConsulat::create(['domaine' => $domaine->id, 'consulat' => $request->consulat, 'inscription' => Auth::id()]);
        } else if ($request->has('bureau')) {
            AffectationDomaineBureau::create(['domaine' => $domaine->id, 'bureau' => $request->bureau, 'inscription' => Auth::id()]);
        }

        return $this->model::find($domaine->id);
    }

    public function getByAmbassade(Request $request, $ambassade)
    {
        $domaines = $this->filterByAmbassades($this->modelQuery, [$ambassade]);
        return $this->refineData($domaines, $request)->latest()->get();
    }

    public function getByConsulat(Request $request, $consulat)
    {
        $domaines = $this->filterByConsulats($this->modelQuery, [$consulat]);
        return $this->refineData($domaines, $request)->latest()->get();
    }


    public function getByMinistere(Request $request, $ministere)
    {
        $domaines = $this->filterByMinisteres($this->modelQuery, [$ministere]);
        return $this->refineData($domaines, $request)->latest()->get();
    }


    public function getByBureau(Request $request, $bureau)
    {
        $domaines = $this->filterByBureaux($this->modelQuery, [$bureau]);
        return $this->refineData($domaines, $request)->latest()->get();
    }
}
