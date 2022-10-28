<?php

namespace App\Traits;


trait GroupeTrait
{
    use BaseTrait;


    public function filterByUserAsMembre($groupes, $user)
    {
        return $groupes->whereHas('membres', function ($q) use ($user) {
            $q->where('membre', $user);
        });
    }


    public function filterByUserAsNonMembre($groupes, $user)
    {
        return $groupes->whereDoesntHave('membres', function ($q) use ($user) {
            $q->where('membre', $user);
        });
    }
}
