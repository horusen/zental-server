<?php

namespace App\Traits;

use App\Traits\BaseTrait;

trait ContactUserTrait
{
    use BaseTrait;


    protected function search($contacts, $keyword)
    {
        return $contacts->whereHas('contact', function ($q) use ($keyword) {
            $q->where('prenom', 'like', '%' . $keyword . '%')->orWhere('nom', 'like', '%' . $keyword . '%');
        });
    }

    protected function filterByUser($contacts, $user)
    {
        return $contacts->whereHas('user', function ($q) use ($user) {
            $q->where('id_inscription', $user);
        });
    }
}
