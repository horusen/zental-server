<?php

namespace App\Http\Controllers;

use App\Models\AffectationBureauLiaison;
use App\Models\AffectationLiaisonAmbassade;
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
        'libelle' => 'required',
        'pays_origine' => 'required|integer|exists:pays,id',
        'pays_siege' => 'required|integer|exists:pays,id',
        'description' => '',
        'ministere' => 'nullable|integer|exists:zen_ministere,id',
        'ambassade' => 'required:ministere|integer|exists:zen_ambassade,id'
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
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


    public function show($id)
    {
        return $this->model::find($id)->append('bureau');
    }


    public function affecter(Request $request)
    {
        $validated = $this->validate($request, [
            'bureau' => 'required|integer|exists:zen_bureau,id',
            'liaison' => 'required|integer|exists:zen_liaison,id'
        ]);


        AffectationBureauLiaison::create([
            'liaison' => $validated['liaison'],
            'bureau' => $validated['bureau'],
            'inscription' => Auth::id()
        ]);

        return Bureau::find($validated['bureau']);
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, $this->validation);
        $entiteDiplomatique = EntiteDiplomatique::add($validated);
        $liaison = $this->model::create(['entite_diplomatique' => $entiteDiplomatique->id, 'inscription' => Auth::id()]);
        AffectationLiaisonAmbassade::create(['ambassade' => $request->ambassade, 'liaison' => $liaison->id, 'inscription' => Auth::id()]);
        AffectationBureauLiaison::create(['bureau' => $request->bureau, 'liaison' => $liaison->id, 'inscription' => Auth::id()]);

        if ($request->has('ministere')) {

            AffectationLiaisonMinistere::create(['ministere' => $request->ministere, 'liaison' => $liaison->id, 'inscription' => Auth::id()]);
        }


        return $this->model::find($liaison->id);
    }
}
