<?php

namespace App\Traits;

trait LiaisonTrait
{
    use EntiteDiplomatiqueTrait;


    public function filterByAmbassades($liaisons, $ambassades)
    {
        return $liaisons->whereHas('ambassades', function ($q) use ($ambassades) {
            $q->where('zen_ambassade.id', $ambassades);
        });
    }
}
