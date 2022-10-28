<?php

namespace App\Http\Controllers;

use App\Models\DemandeAdhesion;
use App\Models\MembreGroupe;
use App\Shared\Controllers\BaseController;
use App\Traits\DemandeAdhesionGroupeTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemandeAdhesionController extends BaseController
{
    use DemandeAdhesionGroupeTrait;

    protected $model = DemandeAdhesion::class;
    protected $validation = [
        'user' => 'required|integer|exists:cpt_inscription,id_inscription',
        'groupe' => 'required|integer|exists:zen_groupe,id',
    ];


    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }

    public function store(Request $request)
    {
        $request->validate($this->validation);

        $membre = MembreGroupe::where('membre', $request->user)->where('groupe', $request->groupe)->first();
        if (isset($membre)) {
            return response()->json(['message' => 'Le user est déjà membre'], 422);
        }

        $demande = DemandeAdhesion::where('user', $request->user)->where('groupe', $request->groupe)->whereNull('validation')->first();
        if (isset($demande)) {
            return response()->json(['message' => 'Le user a déjà une demande en cours'], 422);
        }

        $demande = $this->model::create($request->all() + ['inscription' => Auth::id()]);

        return $this->model::find($demande->id);
    }

    public function valider(Request $request, $id)
    {
        $request->validate($this->validation + ['validation' => 'required']);
        if ($request->validation != 'accepter' && $request->validation != 'refuser') {
            return $this->responseError('Données erronés', 422);
        }
        $demande = $this->model::findOrFail($id);
        $demande->update(['validation' => $request->validation]);

        $membre = null;
        if ($request->validation == 'accepter') {
            $membre = MembreGroupe::create([
                'groupe' => $request->groupe,
                'membre' => $request->user,
                'admin' => false,
                'inscription' => Auth::id()
            ]);
        }

        return response()->json(['membre' => $membre, 'demande' => $demande->refresh()], 200);
    }



    public function getByGroupe(Request $request, $groupe)
    {
        $demandes = $this->filterByGroupe($this->modelQuery, $groupe);
        return $this->refineData($demandes, $request)->latest()->get();
    }

    public function annuler(DemandeAdhesion $demande)
    {
        if (!isset($demande->validation)) {
            return $this->destroy($demande->id);
        }

        return null;
    }
}
