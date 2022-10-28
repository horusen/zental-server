<?php

namespace App\Traits;

trait InscriptionConsulaireTrait
{
    use BaseTrait;

    public function filterByPays($inscriptionsConsulaires, $pays)
    {
        return
            $inscriptionsConsulaires->whereHas('ambassades.entite_diplomatique', function ($q) use ($pays) {
                $q->whereIn('zen_entite_diplomatique.pays_origine', $pays);
            })->orWhereHas('liaisons.entite_diplomatique', function ($q) use ($pays) {
                $q->whereIn('zen_entite_diplomatique.pays_origine', $pays);
            })->orWhereHas('consulats.entite_diplomatique', function ($q) use ($pays) {
                $q->whereIn('zen_entite_diplomatique.pays_origine', $pays);
            });
    }

    public function filterByAmbassades($inscriptionsConsulaires, $ambassades)
    {
        return $inscriptionsConsulaires->whereHas('ambassades', function ($q) use ($ambassades) {
            $q->whereIn('zen_ambassade.id', $ambassades);
        });
    }


    public function filterByLiaisons($inscriptionsConsulaires, $liaisons)
    {
        return $inscriptionsConsulaires->whereHas('liaisons', function ($q) use ($liaisons) {
            $q->whereIn('zen_liaison.id', $liaisons);
        });
    }


    public function filterByEtats($inscriptionsConsulaires, $etats)
    {
        return $inscriptionsConsulaires->whereIn('etat', $etats);
    }


    public function filterByConsulats($inscriptionsConsulaires, $consulats)
    {
        return $inscriptionsConsulaires->whereHas('consulats', function ($q) use ($consulats) {
            $q->whereIn('zen_consulat.id', $consulats);
        });
    }

    public function search($elements, $keyword)
    {
        return $elements->whereHas('user', function ($q) use ($keyword) {
            $q->where('prenom', 'like', '%' . $keyword . '%')->orWhere('nom', 'like', '%' . $keyword . '%');
        });
    }


    public function filter($elements, $filteringParams)
    {
        if (isset($filteringParams['etats'])) {
            $elements = $this->filterByEtats($elements, $filteringParams['etats']);
        }


        return $elements;
    }
}
