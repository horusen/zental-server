<?php

namespace App\Traits;

trait DepartementTrait
{
    use BaseTrait;

    public function filterByBureaux($departements, $bureaux)
    {
        return $departements->whereHas('bureaux', function ($q) use ($bureaux) {
            $q->whereIn('zen_bureau.id', $bureaux);
        });
    }

    public function filterByDomaines($departments, $domaines)
    {
        return $departments->whereIn('domaine', $domaines);
    }


    public function filterByConsulat($departements, $consulats)
    {
        return $departements->whereHas('consulats', function ($q) use ($consulats) {
            $q->whereIn('zen_consulat.id', $consulats);
        });
    }
}
