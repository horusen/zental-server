<?php

namespace App\Traits;

trait DepartementTrait
{
    use BaseTrait;


    public function filterByDomaines($departments, $domaines)
    {
        return $departments->whereIn('domaine', $domaines);
    }
}
