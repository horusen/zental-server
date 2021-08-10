<?php

namespace App\Traits;


trait AdresseTrait
{
    use BaseTrait;



    public function filterByMinisteres($adresses, $ministeres)
    {
        return $adresses->whereHas('entite_diplomatiques.ministere', function ($q) use ($ministeres) {
            $q->whereIn('zen_ministere.id', $ministeres);
        });
    }


    public function filterByAmbassades($adresses, $ambassades)
    {
        return $adresses->whereHas('entite_diplomatiques.ambassade', function ($q) use ($ambassades) {
            $q->whereIn('zen_ambassade.id', $ambassades);
        });
    }



    public function filterByConsulats($adresses, $consulats)
    {
        return $adresses->whereHas('entite_diplomatiques.consulat', function ($q) use ($consulats) {
            $q->whereIn('zen_consulat.id', $consulats);
        });
    }
}
