<?php

namespace App\Http\Controllers;

use App\Models\AffectationBureauAmbassade;
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
        'pays' => 'required|integer|exists:pays,id',
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
        $bureaux = $this->filterByMinisteres($this->modelQuery, [$ministere]);
        return $this->refineData($bureaux, $request)->latest()->get();
    }


    public function getByAmbassade(Request $request, $ambassade)
    {
        $bureaux = $this->filterByAmbassades($this->modelQuery, [$ambassade]);
        return $this->refineData($bureaux, $request)->latest()->get();
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, $this->validation);
        $bureau = $this->model::create(array_merge($validated, ['inscription' => Auth::id()]));

        if ($request->has('ministere')) {

            AffectationBureauMinistere::create(['ministere' => $request->ministere, 'bureau' => $bureau->id, 'inscription' => Auth::id()]);
        } else  if ($request->has('ambassade')) {

            AffectationBureauAmbassade::create(['ambassade' => $request->ambassade, 'bureau' => $bureau->id, 'inscription' => Auth::id()]);
        }


        return $bureau;
    }


    public function update(Request $request, $id)
    {
        $this->isvalid($request);
        $element = $this->model::find($id);
        $element->update(array_merge($request->all(), ['inscription' => Auth::id()]));
        return $this->show($element->id);
    }


    public function show($id)
    {
        $bureau = $this->model::findOrFail($id);


        if (isset($bureau->liaison)) {
            return $bureau->append('liaison');
        } else if (isset($bureau->passerelle)) {
            return $bureau->append('passerelle');
        }

        return $bureau;
    }


    public function affecter(Request $request)
    {
        $validated =  $this->validate($request, [
            'bureau' => 'required|integer|exists:zen_bureau,id',
            'passerelle' => 'required_without:liaison|integer|exists:zen_passerelle,id',
            'liaison' => 'required_without:passerelle|integer|exists:zen_liaison,id',
        ]);



        $this->deletePreviousAffectation($validated['bureau']);

        if ($request->has('liaison')) {
            AffectationBureauLiaison::create([
                'bureau' => $validated['bureau'],
                'liaison' => $validated['liaison'],
                'inscription' => Auth::id()
            ]);


            return Liaison::findOrFail($validated['liaison']);
        }


        if ($request->has('passerelle')) {
            AffectationBureauPasserelle::create([
                'bureau' => $validated['bureau'],
                'passerelle' => $validated['passerelle'],
                'inscription' => Auth::id()
            ]);


            return Passerelle::findOrFail($validated['passerelle']);
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
