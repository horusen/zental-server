<?php

namespace App\Traits;


trait ServiceTrait
{
    use BaseTrait;

    public function filterByDepartements($services, $departements)
    {
        return $services->whereIn('departement', $departements);
    }


    public function filterByDomaines($services, $domaines)
    {
        return $services->whereHas('departement.domaine', function ($q) use ($domaines) {
            $q->where('exp_domaine.id', $domaines);
        });
    }


    public function filterByMinisteres($services, $ministeres)
    {
        return $services->whereHas('ministeres', function ($q) use ($ministeres) {
            $q->where('zen_ministere.id', $ministeres);
        });
    }


    public function filterByBureaux($services, $bureaux)
    {
        return $services->whereHas('bureaux', function ($q) use ($bureaux) {
            $q->where('zen_bureau.id', $bureaux);
        });
    }


    public function filterByAmbassades($services, $ambassades)
    {
        return $services->whereHas('ambassades', function ($q) use ($ambassades) {
            $q->where('zen_ambassade.id', $ambassades);
        });
    }


    public function filterByConsulats($services, $consulats)
    {
        return $services->whereHas('consulats', function ($q) use ($consulats) {
            $q->where('zen_consulat.id', $consulats);
        });
    }

    public function getServiceCommunication($services)
    {
        return $services->where('service_com', 1);
    }

    public function filterByHasChargerCom($services)
    {
        return $services->whereHas('employes', function ($q) {
            $q->where('charger_com', 1);
        });
    }


    public function filter($elements, $filteringParams)
    {
        if (isset($filteringParams['has_charger_com'])) {
            if ($filteringParams['has_charger_com'] == true) {
                $elements = $this->filterByHasChargerCom($elements);
            }
        }

        return $elements;
    }
}
