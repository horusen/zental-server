<?php

namespace App\Http\Controllers;

use App\Models\AffectationEmployeBureau;
use App\Models\AffectationEmployeService;
use App\Models\Employe;
use App\Models\Liaison;
use App\Models\Passerelle;
use App\Shared\Controllers\BaseController;
use App\Traits\EmployeTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeController extends BaseController
{
    use EmployeTrait;
    protected $model = Employe::class;
    protected $validation = [
        'employe' => 'required|integer|exists:cpt_inscription,id_inscription',
        'charger_com' => 'required',
        'poste' => 'required|integer|exists:zen_poste,id',
        'debut' => 'required|date',
        'fin' => 'date',
        'note' => '',
        'fonction' => 'required|integer|exists:zen_fonction,id',
        'service' => 'required_without_all:bureau,liaison,passerelle|integer|exists:zen_service,id',
        'bureau' => 'required_without_all:service,liaison,passerelle|integer|exists:zen_bureau,id',
        'liaison' => 'required_without_all:service,bureau,passerelle|integer|exists:zen_liaison,id',
        'passerelle' => 'required_without_all:service,bureau,liaison|integer|exists:zen_passerelle,id',
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }



    public function store(Request $request)
    {
        // validation de la requets
        $validated = $this->validate($request, $this->validation);

        // Ajout de l'employé
        $employe = $this->model::create(array_merge($validated, ['inscription' => Auth::id(), 'charger_com' => $request->charger_com == 'true' ? 1 : 0]));


        // Affectation de l'employe
        if ($request->has('service')) {
            AffectationEmployeService::create(['service' => $request->service, 'employe' => $employe->id, 'inscription' => Auth::id()]);
        } else  if ($request->has('bureau')) {
            AffectationEmployeBureau::create(['bureau' => $request->bureau, 'employe' => $employe->id, 'inscription' => Auth::id()]);
        } else  if ($request->has('liaison')) {
            $liaison = Liaison::findOrFail($request->liaison);
            AffectationEmployeBureau::create(['bureau' => $liaison->bureau->id, 'employe' => $employe->id, 'inscription' => Auth::id()]);
        } else  if ($request->has('passerelle')) {
            $passerelle = Passerelle::findOrFail($request->passerelle);
            AffectationEmployeBureau::create(['bureau' => $passerelle->bureau->id, 'employe' => $employe->id, 'inscription' => Auth::id()]);
        }


        return $this->model::find($employe->id);
    }




    // Get ministere
    public function getByMinistere(Request $request, $ministere)
    {
        $employes = $this->filterByMinisteres($this->modelQuery, [$ministere]);
        return $this->refineData($employes, $request)->latest()->get();
    }



    // Get by service
    public function getByService(Request $request, $service)
    {
        $employes = $this->filterByServices($this->modelQuery, [$service]);
        return $this->refineData($employes, $request)->latest()->get();
    }

    // Get ambassade
    public function getByAmbassade(Request $request, $ambassade)
    {
        $employes = $this->filterByAmbassades($this->modelQuery, [$ambassade]);
        return $this->refineData($employes, $request)->latest()->get();
    }


    // Get by consulat
    public function getByConsulat(Request $request, $consulat)
    {
        $employes = $this->filterByConsulats($this->modelQuery, [$consulat]);
        return $this->refineData($employes, $request)->latest()->get();
    }


    // Get by fonction
    public function getByFonction(Request $request, $fonction)
    {
        $employes = $this->filterByFonctions($this->modelQuery, [$fonction]);
        return $this->refineData($employes, $request)->latest()->get();
    }


    // Get by poste
    public function getByPoste(Request $request, $poste)
    {
        $employes = $this->filterByPostes($this->modelQuery, [$poste]);
        return $this->refineData($employes, $request)->latest()->get();
    }

    // Get by departement
    public function getByDepartement(Request $request, $departement)
    {
        $employes = $this->filterByDepartements($this->modelQuery, [$departement]);
        return $this->refineData($employes, $request)->latest()->get();
    }

    // Get by  domaine
    public function getByDomaine(Request $request, $domaine)
    {
        $employes = $this->filterByDomaines($this->modelQuery, [$domaine]);
        return $this->refineData($employes, $request)->latest()->get();
    }


    // Get by bureau
    public function getByBureau(Request $request, $bureau)
    {
        $employes = $this->filterBybureaux($this->modelQuery, [$bureau]);
        return $this->refineData($employes, $request)->latest()->get();
    }
}
