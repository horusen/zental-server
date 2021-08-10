<?php

namespace App\Traits;


trait EntiteDiplomatiqueTrait
{
    use BaseTrait;


    public function search($elements, $keyword)
    {
        return $elements->whereHas('entite_diplomatique.pays_siege', function ($q) use ($keyword) {
            $q->where('libelle', 'like', '%' . $keyword . '%');
        });
    }

    protected function filterByMinisteres($elements, $ministeres)
    {
        return $elements->whereHas('entite_diplomatique.pays_origine.entite_diplomatiques.ministere', function ($q) use ($ministeres) {
            $q->whereIn('zen_ministere.id', $ministeres);
        });
    }


    protected function filterByContinents($elements, $continents)
    {
        return $elements->whereHas('entite_diplomatique.pays_siege.continent', function ($q) use ($continents) {
            $q->whereIn('continent.id', $continents);
        });
    }


    protected function filterByLangues($elements, $langues)
    {
        return $elements->whereHas('entite_diplomatique.pays_siege.langue', function ($q) use ($langues) {
            $q->whereIn('langue.id', $langues);
        });
    }

    protected function filterByEtats($elements, $etats)
    {
        return $elements->whereIn('etats', $etats);
    }
}
