<?php

namespace App\Traits;


// trait
trait MinistreTrait
{
    use BaseTrait;
    public function filterByMinisteres($ministres, $ministeres)
    {
        return $ministres->whereIn('ministere', $ministeres);
    }

    public function search($ministres, $keyword)
    {
        return $ministres->whereHas('ministre', function ($q) use ($keyword) {
            $q->where('prenom', 'like', '%' . $keyword . '%')->orWhere('nom', 'like', '%' . $keyword . '%');
        });
    }
}
