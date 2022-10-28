<?php

namespace App\Http\Controllers;

use App\Models\AffectationBureauLiaison;
use App\Models\AffectationLiaisonAmbassade;
use App\Models\AffectationLiaisonConsulat;
use App\Models\AffectationLiaisonMinistere;
use App\Models\Bureau;
use App\Models\EntiteDiplomatique;
use App\Models\Liaison;
use App\Shared\Controllers\BaseController;
use App\Traits\LiaisonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LiaisonController extends BaseController
{
    use LiaisonTrait;
    protected $model = Liaison::class;
    protected $validation = [
        'pays_origine' => 'required|integer|exists:pays,id',
        'pays_siege' => 'required|integer|exists:pays,id',
        'date_creation' => 'required|date',
        'ambassade' => 'required_without:consulat|nullable|integer|exists:zen_ambassade,id',
        'consulat' => 'required_without:ambassade|nullable|integer|exists:zen_consulat,id'
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }

    public function getAllData(Request $request)
    {
        return $this->refineData($this->modelQuery, $request)->latest()->get()->each->append('bureau');
    }

    public function getByMinistere(Request $request, $ministere)
    {
        $liaisons = $this->filterByMinisteres($this->modelQuery, [$ministere]);
        return $this->refineData($liaisons, $request)->latest()->get()->each->append('bureau');
    }


    public function getByAmbassade(Request $request, $ambassade)
    {
        $liaisons = $this->filterByAmbassades($this->modelQuery, [$ambassade]);
        return $this->refineData($liaisons, $request)->latest()->get();
    }

    public function getByConsulat(Request $request, $consulat)
    {
        $liaisons = $this->filterByConsulats($this->modelQuery, [$consulat]);
        return $this->refineData($liaisons, $request)->latest()->get();
    }

    public function getByHasBureauxByPays(Request $request, $pays)
    {
        $liaisons = $this->filterByHasBureaux($this->modelQuery);
        $liaisons = $this->filterByPays($liaisons, [$pays]);
        return $this->refineData($liaisons, $request)->get()->each->append('bureau');
    }


    public function getNonAffecteByMinistere(Request $request, $ministere)
    {
        $liaisons = $this->filterByMinisteres($this->modelQuery, [$ministere]);
        $liaisons = $this->filterByNonAffectation($liaisons);
        return $this->refineData($liaisons, $request)->latest()->get();
    }


    public function getNonAffecteByAmbassade(Request $request, $ambassade)
    {
        $liaisons = $this->filterByAmbassades($this->modelQuery, [$ambassade]);
        $liaisons = $this->filterByNonAffectation($liaisons);
        return $this->refineData($liaisons, $request)->latest()->get();
    }

    public function getNonAffecteByConsulat(Request $request, $consulat)
    {
        $liaisons = $this->filterByConsulats($this->modelQuery, [$consulat]);
        $liaisons = $this->filterByNonAffectation($liaisons);
        return $this->refineData($liaisons, $request)->latest()->get();
    }

    public function show($id)
    {
        return $this->model::find($id)->append('bureau');
    }


    public function affecter(Request $request)
    {
        $this->validate($request, [
            'bureau' => 'required|integer|exists:zen_bureau,id',
            'liaison' => 'required|integer|exists:zen_liaison,id'
        ]);


        $bureau = Bureau::find($request->bureau);
        $liaison = $this->model::find($request->liaison);

        AffectationBureauLiaison::create([
            'liaison' => $liaison->id,
            'bureau' => $bureau->id,
            'inscription' => Auth::id()
        ]);


        EntiteDiplomatique::edit($bureau->entite_diplomatique, ['pays_siege' => $liaison->pays_siege]);

        return $bureau->refresh();
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validation);
        $liaison = $this->model::create($request->all() + ['inscription' => Auth::id()]);


        if ($request->has('consulat')) {
            AffectationLiaisonConsulat::create([
                'consulat' => $request->consulat,
                'liaison' => $liaison->id,
                'inscription' => Auth::id()
            ]);
        } else if ($request->has('ambassade')) {
            AffectationLiaisonAmbassade::create([
                'ambassade' => $request->ambassade,
                'liaison' => $liaison->id,
                'inscription' => Auth::id()
            ]);
        }


        if ($request->has('bureau')) {
            AffectationBureauLiaison::create([
                'bureau' => $request->bureau,
                'liaison' => $liaison->id,
                'inscription' => Auth::id()
            ]);
        }



        return $this->model::find($liaison->id);
    }
}
