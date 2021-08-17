<?php

namespace App\Traits;

use App\Traits\BaseTrait;

trait RelationInterpersonnelleTrait
{
    use BaseTrait;


    protected function search($relations, $keyword)
    {
        return $relations->whereHas('user1', function ($q) use ($keyword) {
            $q->where('prenom', 'like', '%' . $keyword . '%')->orWhere('nom', 'like', '%' . $keyword . '%');
        })->orWhereHas('user2', function ($q) use ($keyword) {
            $q->where('prenom', 'like', '%' . $keyword . '%')->orWhere('nom', 'like', '%' . $keyword . '%');
        });
    }

    protected function filterByUser($relations, $user)
    {
        return $relations->whereHas('user1', function ($q) use ($user) {
            $q->where('id_inscription', $user);
        })->orWhereHas('user2', function ($q) use ($user) {
            $q->where('id_inscription', $user);
        });
    }
}
