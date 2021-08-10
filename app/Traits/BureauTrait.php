<?php

namespace App\Traits;

trait BureauTrait
{
    use BaseTrait;



    public function filterByMinisteres($bureaux, $ministeres)
    {
        return $bureaux->whereHas('ministeres', function ($q) use ($ministeres) {
            $q->where('zen_ministere.id', $ministeres);
        });
    }


    public function filterByAmbassades($bureaux, $ambassades)
    {
        return $bureaux->whereHas('ambassades', function ($q) use ($ambassades) {
            $q->where('zen_ambassade.id', $ambassades);
        });
    }
}
