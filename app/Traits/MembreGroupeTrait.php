<?php

namespace App\Traits;


trait MembreGroupeTrait
{
    use BaseTrait;

    public function filterByGroupe($membres, $groupe)
    {
        return $membres->where('groupe', $groupe);
    }


    protected function search($membres, $keyword)
    {
        return $membres->whereHas('membre', function ($q) use ($keyword) {
            $q->where('prenom', 'like', '%' . $keyword . '%')->orWhere('prenom', 'like', '%' . $keyword . '%');
        });
    }
}
