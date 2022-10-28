<?php

namespace App\Http\Controllers;

use App\Models\AffectationAmbassadeurAmbassade;
use App\Models\AffectationConsuleConsulat;
use App\Models\AffectationMinistreMinistere;
use App\Models\Employe;
use App\Shared\Controllers\BaseController;
use App\Traits\ResponsableEntiteTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ResponsableController extends BaseController
{
    use ResponsableEntiteTrait;
    protected $model = Employe::class;
    protected $validation = [
        'responsable' => 'required|integer|exists:cpt_inscription,id_inscription',
        'poste' => 'required|integer|in:1,2,3',
        'debut' => 'required|date',
        'note' => '',
        'fin' => 'required_if:en_fonction,false',
        'ministere' => 'required_without_all:consulat,ambassade|integer|exists:zen_ministere,id',
        'consulat' => 'required_without_all:ministere,ambassade|integer|exists:zen_consulat,id',
        'ambassade' => 'required_without_all:ministere,consulat|integer|exists:zen_ambassade,id',
        'en_fonction' => 'required|boolean'
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
        $this->modelQuery = $this->model::whereIn('poste', [1, 2, 3]);
    }

    public function store(Request $request)
    {

        $validated = $this->validate($request, $this->validation);

        $responsable = $this->model::create([
            'employe' => $validated['responsable'],
            'poste' => $validated['poste'],
            'debut' => $validated['debut'],
            'fin' => isset($validated['fin']) ? $validated['fin'] : null,
            'note' => $validated['note'],
            'inscription' => Auth::id()
        ]);


        if ($request->has('ministere')) {
            $affectation = AffectationMinistreMinistere::create([
                'ministre' => $responsable->id,
                'ministere' => $validated['ministere'],
                'inscription' => Auth::id(),
                'en_fonction' => $validated['en_fonction']
            ]);

            if ($affectation->en_fonction == true) {
                AffectationMinistreMinistere::setEnFonctionFiedToFalseExceptOne($affectation->id);
            }
        } else if ($request->has('ambassade')) {
            $affectation = AffectationAmbassadeurAmbassade::create([
                'ambassadeur' => $responsable->id,
                'ambassade' => $validated['ambassade'],
                'inscription' => Auth::id(),
                'en_fonction' => $validated['en_fonction']
            ]);
            if ($affectation->en_fonction == true) {
                AffectationAmbassadeurAmbassade::setEnFonctionFiedToFalseExceptOne($affectation->id);
            }
        } else if ($request->has('consulat')) {
            $affectation = AffectationConsuleConsulat::create([
                'consule' => $responsable->id,
                'consulat' => $validated['consulat'],
                'inscription' => Auth::id(),
                'en_fonction' => $validated['en_fonction']
            ]);
            if ($affectation->en_fonction == true) {
                AffectationConsuleConsulat::setEnFonctionFiedToFalseExceptOne($affectation->id);
            }
        }


        return $this->model::find($responsable->id);
    }


    public function getAnciensMinistres(Request $request,  $ministere)
    {
        $ministres = $this->filterByMinisteres($this->modelQuery, [$ministere], false);
        return $this->refineData($ministres, $request)->latest()->get();
    }

    public function getAnciensAmbassadeurs(Request $request,  $ambassade)
    {
        $ambassadeurs = $this->filterByAmbassades($this->modelQuery, [$ambassade]);
        return $this->refineData($ambassadeurs, $request)->latest()->get();
    }

    public function getAnciensConsules(Request $request,  $consulat)
    {
        $consules = $this->filterByConsulats($this->modelQuery, [$consulat]);
        return $this->refineData($consules, $request)->latest()->get();
    }


    public function getActuelMinistre($ministere)
    {
        $ministres = $this->filterByMinisteres($this->modelQuery, [$ministere], true);
        return $ministres->first();
    }


    public function getActuelAmbassadeur($ambassade)
    {
        $ministres = $this->filterByAmbassades($this->modelQuery, [$ambassade], true);
        return $ministres->first();
    }

    public function getActuelConsule($consulat)
    {
        $ministres = $this->filterByConsulats($this->modelQuery, [$consulat], true);
        return $ministres->first();
    }
}
