<?php

namespace App\Traits;


trait DemandeAdhesionGroupeTrait
{
    use BaseTrait;


    public function filterByGroupe($demandes, $groupe)
    {
        return $demandes->where('groupe', $groupe)->whereNull('validation');
    }
}
