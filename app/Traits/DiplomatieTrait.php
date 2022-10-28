<?php

namespace App\Traits;

trait DiplomatieTrait
{
    use BaseTrait;


    public function filterByPays($diplomaties, $pays)
    {
        return   $diplomaties->whereHas('ps_entite_diplomatiques', function ($q) use ($pays) {
            $q->where('pays_origine', $pays);
        });
    }


    public function filterAilleursByPays($diplomaties, $pays)
    {
        return $diplomaties->whereHas('ps_entite_diplomatiques', function ($q) use ($pays) {
            $q->where('pays_origine', '!=', $pays);
        });
    }
}
