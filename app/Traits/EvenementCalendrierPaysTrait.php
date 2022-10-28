<?php

namespace App\Traits;


trait EvenementCalendrierPaysTrait {
    use BaseTrait;


    public function filterByPays($evenements, $pays){
      return $evenements->whereIn('pays', $pays);
    }
}
