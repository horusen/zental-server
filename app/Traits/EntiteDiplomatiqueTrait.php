<?php

namespace App\Traits;


trait EntiteDiplomatiqueTrait
{
    use BaseTrait;

    // search
    public function search($elements, $keyword)
    {
        return $elements->whereHas('entite_diplomatique.pays_siege', function ($q) use ($keyword) {
            $q->where('libelle', 'like', '%' . $keyword . '%');
        });
    }

    // Filter by ministre
    protected function filterByMinisteres($elements, $ministeres)
    {
        return $elements->whereHas('entite_diplomatique.pays_origine.entite_diplomatiques.ministere', function ($q) use ($ministeres) {
            $q->whereIn('zen_ministere.id', $ministeres);
        });
    }

    // filter by pays
    public function filterByPays($elements, $pays)
    {
        return $elements->whereHas('entite_diplomatique.pays_origine', function ($q) use ($pays) {
            $q->whereIn('pays.id', $pays);
        });
    }


    // Filter by continents
    protected function filterByContinents($elements, $continents)
    {
        return $elements->whereHas('entite_diplomatique.pays_siege.continent', function ($q) use ($continents) {
            $q->whereIn('continent.id', $continents);
        });
    }

    // filter by langues
    protected function filterByLangues($elements, $langues)
    {
        return $elements->whereHas('entite_diplomatique.pays_siege.langue', function ($q) use ($langues) {
            $q->whereIn('langue.id', $langues);
        });
    }

    // filter by ets
    protected function filterByEtats($elements, $etats)
    {
        return $elements->whereIn('etats', $etats);
    }
}
