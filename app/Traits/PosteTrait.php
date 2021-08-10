<?php

namespace App\Traits;

trait PosteTrait
{
    use BaseTrait;

    public function filterByMinisteres($postes, $ministeres)
    {
        return $postes->whereHas('ministeres', function ($q) use ($ministeres) {
            $q->where('zen_ministere.id', $ministeres);
        });
    }


    public function filterByAmbassades($postes, $ambassades)
    {
        return $postes->whereHas('ambassades', function ($q) use ($ambassades) {
            $q->where('zen_ambassade.id', $ambassades);
        });
    }
}
