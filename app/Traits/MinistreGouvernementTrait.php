<?php

namespace App\Traits;


trait MinistreGouvernementTrait {
    use BaseTrait;



    public function filterByPays($ministres, $pays){
      return $ministres->whereIn('pays', $pays);
    }


    protected function search($users, $keyword)
    {
        return $users->where('prenom', 'like', '%' . $keyword . '%')->orWhere('prenom', 'like', '%' . $keyword . '%');
    }
}
