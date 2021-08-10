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


    public function filterByAmbassades($services, $ambassades)
    {
        return $services->whereHas('ambassades', function ($q) use ($ambassades) {
            $q->where('zen_ambassade.id', $ambassades);
        });
    }
}
