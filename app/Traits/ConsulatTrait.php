<?php

namespace App\Traits;

trait ConsulatTrait
{
    use EntiteDiplomatiqueTrait;


    public function filterByAmbassades($consulats, $ambassades)
    {
        return $consulats->whereHas('ambassades', function ($q) use ($ambassades) {
            $q->where('zen_ambassade.id', $ambassades);
        });
    }


    public function filterByUser($consulats, $user)
    {
        return $consulats->where('inscription', $user);
    }
}
