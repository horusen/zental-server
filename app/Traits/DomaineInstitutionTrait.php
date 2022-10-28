<?php

namespace App\Traits;

trait DomaineInstitutionTrait
{
    use BaseTrait;

    public function filterByBureaux($domaines, $bureaux)
    {
        return $domaines->whereHas('bureaux', function ($q) use ($bureaux) {
            $q->whereIn('zen_bureau.id', $bureaux);
        });
    }


    public function filterByMinisteres($domaines, $ministeres)
    {
        return $domaines->whereHas('ministeres', function ($q) use ($ministeres) {
            $q->whereIn('zen_ministere.id', $ministeres);
        });
    }


    public function filterByAmbassades($domaines, $ambassades)
    {
        return $domaines->whereHas('ambassades', function ($q) use ($ambassades) {
            $q->whereIn('zen_ambassade.id', $ambassades);
        })->orWhereHas('ministeres.ambassades', function ($q) use ($ambassades) {
            $q->whereIn('zen_ambassade.id', $ambassades);
        });;
    }



    public function filterByConsulats($domaines, $consulats)
    {
        return $domaines->whereHas('consulats', function ($q) use ($consulats) {
            $q->whereIn('zen_consulat.id', $consulats);
        })->orWhereHas('ministeres.ambassades.consulats', function ($q) use ($consulats) {
            $q->whereIn('zen_consulat.id', $consulats);
        })->orWhereHas('ministeres.consulats', function ($q) use ($consulats) {
            $q->whereIn('zen_consulat.id', $consulats);
        });
    }
}
