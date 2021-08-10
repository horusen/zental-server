<?php

namespace App\Http\Controllers;

use App\Models\AffectationServiceAmbassade;
use App\Models\AffectationServiceMinistere;
use App\Models\Service;
use App\Shared\Controllers\BaseController;
use App\Traits\ServiceTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends BaseController
{
    use ServiceTrait;
    protected $model = Service::class;
    protected $validation = [
        'libelle' => 'required',
        'description' => '',
        'departement' => 'required|integer|exists:zen_departement,id',
        'ministere' => 'required_without:ambassade|integer|exists:zen_ministere,id',
        'ambassade' => 'required_without:ministere|integer|exists:zen_ambassade,id'
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }

    public function getByMinistere(Request $request, $ministere)
    {
        $services = $this->filterByMinisteres($this->modelQuery, [$ministere]);
        return $this->refineData($services, $request)->with('ministeres')->latest()->get();
    }




    public function getByDomaine(Request $request, $domaine)
    {
        $services = $this->filterByDomaines($this->modelQuery, [$domaine]);
        return $this->refineData($services, $request)->latest()->get();
    }


    public function getByAmbassade(Request $request, $ambassade)
    {
        $services = $this->filterByAmbassades($this->modelQuery, [$ambassade]);
        return $this->refineData($services, $request)->with('ambassades')->latest()->get();
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, $this->validation);
        $service = $this->model::create(array_merge($validated, ['inscription' => Auth::id()]));

        if ($request->has('ministere')) {

            AffectationServiceMinistere::create(['ministere' => $request->ministere, 'service' => $service->id, 'inscription' => Auth::id()]);
        } else  if ($request->has('ambassade')) {

            AffectationServiceAmbassade::create(['ambassade' => $request->ambassade, 'service' => $service->id, 'inscription' => Auth::id()]);
        }


        return $this->model::find($service->id);
    }

    public function getByDepartement(Request $request, $departement)
    {
        $services = $this->filterByDepartements($this->modelQuery, [$departement]);
        return $this->refineData($services, $request)->latest()->get();
    }


    public function update(Request $request, $id)
    {
        $this->isvalid($request);
        $element = $this->model::find($id);

        $attached = '';

        if ($request->has('ministere')) {
            $attached = 'ministeres';
        } else if ($request->has('ambassade')) {
            $attached = 'ambassades';
        }

        $element->update(array_merge($request->all(), ['inscription' => Auth::id()]));
        return $this->model::with($attached)->find($element->id);
    }
}
