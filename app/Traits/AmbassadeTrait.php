<?php

namespace App\Traits;


trait AmbassadeTrait
{
    use EntiteDiplomatiqueTrait;


    public function filterByUser($ambassades, $user)
    {
        return $ambassades->where('inscription', $user);
    }
}
