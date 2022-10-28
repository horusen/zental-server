<?php

namespace App\Http\Controllers;

use App\Models\AffectationBureauAmbassade;
use App\Models\AffectationBureauConsulat;
use App\Models\AffectationBureauLiaison;
use App\Models\AffectationBureauMinistere;
use App\Models\AffectationBureauPasserelle;
use App\Models\Bureau;
use App\Models\EntiteDiplomatique;
use App\Models\Liaison;
use App\Models\Passerelle;
use App\Shared\Controllers\BaseController;
use App\Traits\BureauTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BureauController extends BaseController
{
    use BureauTrait;
    protected $model = Bureau::class;
    protected $validation = [
        'libelle' => 'required',
        'pays_origine' => 'required|integer|exists:pays,id',
        // 'ministere' => 'required_without_all:ambassade,consulat|integer|exists:zen_ministere,id',
        // 'ambassade' => 'required_without_all:ministere,consulat|integer|exists:zen_ambassade,id',
        // 'consulat' => 'required_without_all:ministere,ambassade|integer|exists:zen_consulat,id'
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }


    public function getAllData(Request $request)
    {
        return $this->refineData($this->modelQuery, $request)->latest()->get();
    }


    public function getByUser(Request $request, $user)
    {
        $bureaux = $this->filterByUsers($this->modelQuery, [$user]);
        return $this->refineData($bureaux, $request)->latest()->get();
    }

    public function getByMinistere(Request $request, $ministere)
    {
        $bureaux = $this->filterByMinisteres($this->modelQuery, [$ministere]);
        return $this->refineData($bureaux, $request)->latest()->get();
    }


    public function getByAmbassade(Request $request, $ambassade)
    {
        $bureaux = $this->filterByAmbassades($this->modelQuery, [$ambassade]);
        return $this->refineData($bureaux, $request)->latest()->get();
    }


    public function getByConsulat(Request $request, $consulat)
    {
        $bureaux = $this->filterByConsulats($this->modelQuery, [$consulat]);
        return $this->refineData($bureaux, $request)->latest()->get();
    }

    public function getNonAffecteByMinistere(Request $request, $ministere)
    {
        $bureaux = $this->filterByMinisteres($this->modelQuery, [$ministere]);
        $bureaux = $this->filterByNonAffectation($bureaux);
        return $this->refineData($bureaux, $request)->latest()->get();
    }


    public function geNonAffectetByAmbassade(Request $request, $ambassade)
    {
        $bureaux = $this->filterByAmbassades($this->modelQuery, [$ambassade]);
        $bureaux = $this->filterByNonAffectation($bureaux);
        return $this->refineData($bureaux, $request)->latest()->get();
    }


    public function getNonAffecteByConsulat(Request $request, $consulat)
    {
        $bureaux = $this->filterByConsulats($this->modelQuery, [$consulat]);
        $bureaux = $this->filterByNonAffectation($bureaux);
        return $this->refineData($bureaux, $request)->latest()->get();
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validation);
        $entiteDiplomatique = EntiteDiplomatique::create($request->all() + ['inscription' => Auth::id()]);
        $bureau = $this->model::create(['entite_diplomatique' => $entiteDiplomatique->id, 'inscription' => Auth::id()]);

        if ($request->has('ministere')) {
            AffectationBureauMinistere::create(['ministere' => $request->ministere, 'bureau' => $bureau->id, 'inscription' => Auth::id()]);
        } else  if ($request->has('ambassade')) {
            AffectationBureauAmbassade::create(['ambassade' => $request->ambassade, 'bureau' => $bureau->id, 'inscription' => Auth::id()]);
        } else if ($request->has('consulat')) {
            AffectationBureauConsulat::create(['consulat' => $request->consulat, 'bureau' => $bureau->id, 'inscription' => Auth::id()]);
        }


        return $this->model::find($bureau->id);
    }


    public function update(Request $request, $id)
    {
        $this->isvalid($request);
        $element = $this->model::find($id);
        EntiteDiplomatique::edit($element->entite_diplomatique, $request->all());
        return $this->show($element->id);
    }


    public function show($id)
    {
        $bureau = $this->model::findOrFail($id)->append([
            'ministere', 'ambassade', 'consulat',
            'liaison', 'passerelle'
        ]);




        return $bureau;
    }


    public function affecter(Request $request)
    {
        $this->validate($request, [
            'bureau' => 'required|integer|exists:zen_bureau,id',
            'passerelle' => 'required_without:liaison|integer|exists:zen_passerelle,id',
            'liaison' => 'required_without:passerelle|integer|exists:zen_liaison,id',
        ]);



        $this->deletePreviousAffectation($request->bureau);

        if ($request->has('liaison')) {
            $liaison = Liaison::findOrFail($request->liaison);
            AffectationBureauLiaison::create([
                'bureau' => $request->bureau,
                'liaison' => $liaison->id,
                'inscription' => Auth::id()
            ]);

            $bureau = $this->model::findOrFail($request->bureau);
            EntiteDiplomatique::edit($bureau->entite_diplomatique, ['pays_siege' => $liaison->pays_siege]);


            return $liaison;
        }


        if ($request->has('passerelle')) {
            $passerelle = Passerelle::findOrFail($request->passerelle);
            AffectationBureaupasserelle::create([
                'bureau' => $request->bureau,
                'passerelle' => $passerelle->id,
                'inscription' => Auth::id()
            ]);

            $bureau = $this->model::findOrFail($request->bureau);
            EntiteDiplomatique::edit($bureau->entite_diplomatique, ['pays_siege' => $passerelle->pays_siege]);


            return $passerelle;
        }
    }


    public function deletePreviousAffectation($bureau)
    {
        $affectationLiaisons = AffectationBureauLiaison::where('bureau', $bureau)->get();
        $affectationPasserelles = AffectationBureauPasserelle::where('bureau', $bureau)->get();


        foreach ($affectationLiaisons as $liaison) {
            $liaison->delete();
        }


        foreach ($affectationPasserelles as $passerelle) {
            $passerelle->delete();
        }
    }
}
