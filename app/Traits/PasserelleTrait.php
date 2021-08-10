<?php

namespace App\Traits;

trait PasserelleTrait
{
    use EntiteDiplomatiqueTrait;


    public function filterByPays($passerelle, $pays)
    {
        return $passerelle->whereHas('entite_diplomatique.pays_origine', function ($q) use ($pays) {
            $q->where('pays.id', $pays);
        });
    }
}
