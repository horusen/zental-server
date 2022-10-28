<?php

namespace App\Http\Controllers;

use App\Models\AffectationFonctionAmbassade;
use App\Models\AffectationFonctionBureau;
use App\Models\AffectationFonctionConsulat;
use App\Models\AffectationFonctionMinistere;
use App\Models\Fonction;
use App\Shared\Controllers\BaseController;
use App\Traits\FonctionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FonctionController extends BaseController
{
    use FonctionTrait;
    protected $model = Fonction::class;
    protected $validation = [
        'libelle' => 'required',
        'ministere' => 'required_without_all:ambassade,consulat,bureau|integer|exists:zen_ministere,id',
        'ambassade' => 'required_without_all:ministere,consulat,bureau|integer|exists:zen_ambassade,id',
        'consulat' => 'required_without_all:ministere,ambassade,bureau|integer|exists:zen_consulat,id',
        'bureau' => 'required_without_all:ministere,ambassade,consulat|integer|exists:zen_bureau,id',
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }

    public function store(Request $request)
    {
        $this->isValid($request, $this->validation);

        $fonction = Fonction::create(array_merge($request->all(), ['inscription' => Auth::id()]));

        if ($request->has('ministere')) {
            AffectationFonctionMinistere::create(['fonction' => $fonction->id, 'ministere' => $request->ministere, 'inscription' => Auth::id()]);
        } else if ($request->has('ambassade')) {
            AffectationFonctionAmbassade::create(['fonction' => $fonction->id, 'ambassade' => $request->ambassade, 'inscription' => Auth::id()]);
        } else if ($request->has('consulat')) {
            AffectationFonctionConsulat::create(['fonction' => $fonction->id, 'consulat' => $request->consulat, 'inscription' => Auth::id()]);
        } else if ($request->has('bureau')) {
            AffectationFonctionBureau::create(['fonction' => $fonction->id, 'bureau' => $request->bureau, 'inscription' => Auth::id()]);
        }

        return $fonction;
    }


    public function getByService($service)
    {
        return $this->filterByServices($this->modelQuery, [$service])->latest()->get();
    }

    public function getByAmbassade(Request $request, $ambassade)
    {
        $fonctions = $this->filterByAmbassades($this->modelQuery, [$ambassade]);

        return $this->refineData($fonctions, $request)->latest()->get();
    }


    public function getByMinistere(Request $request, $ministere)
    {
        $fonctions = $this->filterByMinisteres($this->modelQuery, [$ministere]);

        return $this->refineData($fonctions, $request)->latest()->get();
    }

    public function getByConsulat(Request $request, $consulat)
    {
        $fonctions = $this->filterByConsulats($this->modelQuery, [$consulat]);

        return $this->refineData($fonctions, $request)->latest()->get();
    }

    public function getByBureau(Request $request, $bureau)
    {
        $departements = $this->filterByBureaux($this->modelQuery, [$bureau]);
        return $this->refineData($departements, $request)->latest()->get();
    }
}
