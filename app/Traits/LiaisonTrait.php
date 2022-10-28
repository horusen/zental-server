<?php

namespace App\Traits;

trait LiaisonTrait
{
    use BaseTrait;

    // filter by ministeres
    public function filterByMinisteres($liaisons, $ministeres)
    {
        return $liaisons->whereHas('ambassades.entite_diplomatique.pays_origine.entite_diplomatiques.ministere', function ($q) use ($ministeres) {
            $q->whereIn('zen_ministere.id', $ministeres);
        })->orWhereHas('consulats.entite_diplomatique.pays_origine.entite_diplomatiques.ministere', function ($q) use ($ministeres) {
            $q->whereIn('zen_ministere.id', $ministeres);
        });
    }

    // Filter by ambassades
    public function filterByAmbassades($liaisons, $ambassades)
    {
        return $liaisons->whereHas('ambassades', function ($q) use ($ambassades) {
            $q->where('zen_ambassade.id', $ambassades);
        });
    }


    // Filter by has bureaux
    public function filterByHasBureaux($liaisons)
    {
        return $liaisons->has('bureaux');
    }

    // Filter by pays
    public function filterByPays($liaisons, $pays)
    {
        return $liaisons->whereHas('pays_origine', function ($q) use ($pays) {
            $q->whereIn('pays.id', $pays);
        });
    }

    // filter by consulat
    public function filterByConsulats($liaisons, $consulats)
    {
        return $liaisons->whereHas('consulats', function ($q) use ($consulats) {
            $q->where('zen_consulat.id', $consulats);
        });
    }

    // filter by non affectation
    public function filterByNonAffectation($liaisons)
    {
        return $liaisons->whereDoesntHave('bureaux', function ($q) {
            $q;
        });
    }
}
