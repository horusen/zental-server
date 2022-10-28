<?php

namespace App\Traits;


trait AdresseTrait
{
    use BaseTrait;



    public function filterByMinisteres($adresses, $ministeres)
    {
        return $adresses->whereHas('entite_diplomatiques.ministere', function ($q) use ($ministeres) {
            $q->whereIn('zen_ministere.id', $ministeres);
        });
    }


    public function filterByBureaux($adresses, $bureaux)
    {
        return $adresses->whereHas('entite_diplomatiques.bureau', function ($q) use ($bureaux) {
            $q->whereIn('zen_bureau.id', $bureaux);
        });
    }


    public function filterByAmbassades($adresses, $ambassades)
    {
        return $adresses->whereHas('entite_diplomatiques.ambassade', function ($q) use ($ambassades) {
            $q->whereIn('zen_ambassade.id', $ambassades);
        });
    }



    public function filterByConsulats($adresses, $consulats)
    {
        return $adresses->whereHas('entite_diplomatiques.consulat', function ($q) use ($consulats) {
            $q->whereIn('zen_consulat.id', $consulats);
        });
    }

    public function filterByUser($addresses, $users)
    {
        return $addresses->whereHas('user', function ($q) use ($users) {
            $q->whereIn('id_inscription', $users);
        });
    }
}
