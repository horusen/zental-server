<?php

namespace App\Http\Controllers;

use App\Models\AffectationFonctionBureau;
use App\Models\AffectationPosteAmbassade;
use App\Models\AffectationPosteBureau;
use App\Models\AffectationPosteConsulat;
use App\Models\AffectationPosteMinistere;
use App\Models\Poste;
use App\Shared\Controllers\BaseController;
use App\Traits\PosteTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PosteController extends BaseController
{
    use PosteTrait;
    protected $model = Poste::class;
    protected $validation = [
        'libelle' => 'required',
        'description' => '',
        'domaine' => 'required|integer|exists:zen_domaine_institution,id',
        'ministere' => 'required_without_all:ambassade,consulat,bureau|integer|exists:zen_ministere,id',
        'ambassade' => 'required_without_all:ministere,consulat,bureau|integer|exists:zen_ambassade,id',
        'consulat' => 'required_without_all:ministere,ambassade,bureau|integer|exists:zen_consulat,id',
        'bureau' => 'required_without_all:ministere,ambassade,consulat|integer|exists:zen_bureau,id',
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }

    public function getAll()
    {
        $this->model->apply
        return $this->model::whereNotIn('id', [1, 2, 3])->get();
    }


    public function getByService($service)
    {
        // return response()->json(['test' => $service]);
        return $this->filterByServices($this->modelQuery, [$service])->get();
    }


    public function getByMinistere(Request $request, $ministere)
    {
        $postes = $this->filterByMinisteres($this->modelQuery, [$ministere]);
        return $this->refineData($postes, $request)->latest()->get();
    }


    public function getByAmbassade(Request $request, $ambassade)
    {
        $postes = $this->filterByAmbassades($this->modelQuery, [$ambassade]);
        return $this->refineData($postes, $request)->latest()->get();
    }


    public function getByConsulat(Request $request, $consulat)
    {
        $postes = $this->filterByConsulats($this->modelQuery, [$consulat]);
        return $this->refineData($postes, $request)->latest()->get();
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, $this->validation);
        $poste = $this->model::create(array_merge($validated, ['inscription' => Auth::id()]));

        if ($request->has('ministere')) {
            AffectationPosteMinistere::create(['ministere' => $request->ministere, 'poste' => $poste->id, 'inscription' => Auth::id()]);
        } else  if ($request->has('ambassade')) {
            AffectationPosteAmbassade::create(['ambassade' => $request->ambassade, 'poste' => $poste->id, 'inscription' => Auth::id()]);
        } else  if ($request->has('consulat')) {
            AffectationPosteConsulat::create(['consulat' => $request->consulat, 'poste' => $poste->id, 'inscription' => Auth::id()]);
        } else if ($request->has('bureau')) {
            AffectationPosteBureau::create(['poste' => $poste->id, 'bureau' => $request->bureau, 'inscription' => Auth::id()]);
        }


        return $poste;
    }


    public function getByBureau(Request $request, $bureau)
    {
        $departements = $this->filterByBureaux($this->modelQuery, [$bureau]);
        return $this->refineData($departements, $request)->latest()->get();
    }
}
