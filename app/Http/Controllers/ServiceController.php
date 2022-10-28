<?php

namespace App\Http\Controllers;

use App\Model\AffectationServiceConsulat;
use App\Models\AffectationServiceAmbassade;
use App\Models\AffectationServiceBureau;
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
        'ministere' => 'required_without_all:ambassade,consulat,bureau|integer|exists:zen_ministere,id',
        'ambassade' => 'required_without_all:ministere,consulat,bureau|integer|exists:zen_ambassade,id',
        'consulat' => 'required_without_all:ministere,ambassade,bureau|integer|exists:zen_consulat,id',
        'bureau' => 'required_without_all:ministere,ambassade,consulat|integer|exists:zen_bureau,id',
        'service_com' => 'required|boolean'
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }

    public function getByMinistere(Request $request, $ministere)
    {
        $services = $this->filterByMinisteres($this->modelQuery, [$ministere]);
        return $this->refineData($services, $request)->with(['ministeres'])->latest()->get();
    }




    public function getByDomaine(Request $request, $domaine)
    {
        $services = $this->filterByDomaines($this->modelQuery, [$domaine]);
        return $this->refineData($services, $request)->latest()->get();
    }


    public function getByBureau(Request $request, $bureau)
    {
        $services = $this->filterByBureaux($this->modelQuery, [$bureau]);
        return $this->refineData($services, $request)->latest()->get();
    }


    public function getByAmbassade(Request $request, $ambassade)
    {
        $services = $this->filterByAmbassades($this->modelQuery, [$ambassade]);
        return $this->refineData($services, $request)->with('ambassades')->latest()->get();
    }

    public function store(Request $request)
    {
        $request->validate($this->validation);
        $service = $this->model::create($request->except('service_communication') + ['inscription' => Auth::id()]);

        // if ($request->service_com == true) {
        //     $service_coms = $this->model::where('service_com', 1)->get();
        //     foreach ($service_coms as $service_com) {
        //         $service_com->update(['service_com' => 0]);
        //     }

        //     $service->update(['service_com' => 1]);
        // }



        if ($request->has('ministere')) {
            AffectationServiceMinistere::create(['ministere' => $request->ministere, 'service' => $service->id, 'inscription' => Auth::id()]);
            $services = $this->filterByMinisteres($this->modelQuery, [$request->ministere])->get();
            $this->_updateServiceCommunicationLocally($services, $service);
        } else if ($request->has('ambassade')) {
            AffectationServiceAmbassade::create(['ambassade' => $request->ambassade, 'service' => $service->id, 'inscription' => Auth::id()]);
            $services = $this->filterByAmbassades($this->modelQuery, [$request->ambassade])->get();
            $this->_updateServiceCommunicationLocally($services, $service);
        } else  if ($request->has('consulat')) {
            AffectationServiceConsulat::create(['consulat' => $request->consulat, 'service' => $service->id, 'inscription' => Auth::id()]);
            $services = $this->filterByConsulats($this->modelQuery, [$request->consulat])->get();
            $this->_updateServiceCommunicationLocally($services, $service);
        } else  if ($request->has('bureau')) {
            AffectationServiceBureau::create(['bureau' => $request->bureau, 'service' => $service->id, 'inscription' => Auth::id()]);
            $services = $this->filterByBureaux($this->modelQuery, [$request->bureau])->get();
            $this->_updateServiceCommunicationLocally($services, $service);
        }


        return $this->model::find($service->id);
    }

    public function getByDepartement(Request $request, $departement)
    {
        $services = $this->filterByDepartements($this->modelQuery, [$departement]);
        return $this->refineData($services, $request)->latest()->get();
    }


    public function getByConsulat(Request $request, $consulat)
    {
        $services = $this->filterByConsulats($this->modelQuery, [$consulat]);
        return $this->refineData($services, $request)->latest()->get();
    }


    public function getServiceCommunicationMinistere($ministere)
    {
        $services = $this->filterByMinisteres($this->modelQuery, [$ministere]);
        return $this->getServiceCommunication($services)->first();
    }

    public function getServiceCommunicationAmbassade($ambassade)
    {
        $services = $this->filterByAmbassades($this->modelQuery, [$ambassade]);
        return $this->getServiceCommunication($services)->first();
    }

    public function getServiceCommunicationConsulat($consulat)
    {
        $services = $this->filterByConsulats($this->modelQuery, [$consulat]);
        return $this->getServiceCommunication($services)->first();
    }


    public function getServiceCommunicationBureau($bureau)
    {
        $services = $this->filterByBureaux($this->modelQuery, [$bureau]);
        return $this->getServiceCommunication($services)->first();
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

        $element->update(array_merge($request->except('service_com'), ['inscription' => Auth::id()]));
        return $this->model::with($attached)->find($element->id);
    }

    public function updateServiceCommunication(Request $request, Service $service)
    {
        $request->validate([
            'service_com' => 'required|boolean',
            'ministere' => 'required_without_all:ambassade,consulat,bureau|integer|exists:zen_ministere,id',
            'ambassade' => 'required_without_all:ministere,consulat,bureau|integer|exists:zen_ambassade,id',
            'consulat' => 'required_without_all:ambassade,ministere,bureau|integer|exists:zen_consulat,id',
            'bureau' => 'required_without_all:ambassade,consulat,ministere|integer|exists:zen_bureau,id',
        ]);


        if ($request->service_com == true) {

            $services = [];

            if ($request->has('ministere')) {
                $services = $this->filterByMinisteres($this->modelQuery, [$request->ministere])->get();
            } else if ($request->has('ambassade')) {
                $services = $this->filterByAmbassades($this->modelQuery, [$request->ambassade])->get();
            } else if ($request->has('consulat')) {
                $services = $this->filterByConsulats($this->modelQuery, [$request->consulat])->get();
            } else if ($request->has('bureau')) {
                $services = $this->filterByBureaux($this->modelQuery, [$request->bureau])->get();
            }

            $this->_updateServiceCommunicationLocally($services, $service);
        } else if ($request->service_com == false) {
            $service->update(['service_com' => 0]);
        }

        return $service->refresh();
    }

    private function _updateServiceCommunicationLocally($services, $service)
    {
        foreach ($services as $_service) {
            $_service->update(['service_com' => 0]);
        }
        $service->update(['service_com' => 1]);
    }
}
