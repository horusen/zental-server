<?php

namespace App\Traits;

trait FonctionTrait
{
    use BaseTrait;

    // Filter by bureau
    public function filterByBureaux($fonctions, $bureaux)
    {
        return $fonctions->whereHas('bureaux', function ($q) use ($bureaux) {
            $q->whereIn('zen_bureau.id', $bureaux);
            // })->orWhereHas('consulats.bureaux', function ($q) use ($fonctions) {
            //     $q->whereIn('zen_bureau.id', $fonctions);
            // })->orWhereHas('ambassades.consulats.bureaux', function ($q) use ($fonctions) {
            //     $q->whereIn('zen_bureau.id', $fonctions);
            // })->orWhereHas('ministeres.ambassades.consulats.bureaux', function ($q) use ($fonctions) {
            //     $q->whereIn('zen_bureau.id', $fonctions);
            // })->orWhereHas('ambassades.bureaux', function ($q) use ($fonctions) {
            //     $q->whereIn('zen_bureau.id', $fonctions);
            // })->orWhereHas('ministeres.ambassades.bureaux', function ($q) use ($fonctions) {
            //     $q->whereIn('zen_bureau.id', $fonctions);
            // })->orWhereHas('ministeres.bureaux', function ($q) use ($fonctions) {
            //     $q->whereIn('zen_bureau.id', $fonctions);
        });
    }


    // filter by ministere
    public function filterByMinisteres($fonctions, $ministeres)
    {
        return $fonctions->whereHas('ministeres', function ($q) use ($ministeres) {
            $q->whereIn('zen_ministere.id', $ministeres);
        });
    }

    // filter by service
    public function filterByServices($fonctions, $services)
    {
        return $fonctions->whereHas('ministeres.services', function ($q) use ($services) {
            $q->whereIn('zen_service.id', $services);
        })->orWhereHas('ambassades.services', function ($q) use ($services) {
            $q->whereIn('zen_service.id', $services);
        })->orWhereHas('consulats.services', function ($q) use ($services) {
            $q->whereIn('zen_service.id', $services);
        })->orWhereHas('bureaux.services', function ($q) use ($services) {
            $q->whereIn('zen_service.id', $services);
        });
    }

    // filter by ambassade
    public function filterByAmbassades($fonctions, $ambassades)
    {
        return $fonctions->whereHas('ambassades', function ($q) use ($ambassades) {
            $q->whereIn('zen_ambassade.id', $ambassades);
        })->orWhereHas('ministeres.ambassades', function ($q) use ($ambassades) {
            $q->whereIn('zen_ambassade.id', $ambassades);
        });
    }


    // filter by consulats
    public function filterByConsulats($fonctions, $consulats)
    {
        return $fonctions->whereHas('consulats', function ($q) use ($consulats) {
            $q->whereIn('zen_consulat.id', $consulats);
        });


        // ->orWhereHas('ministeres.ambassades.consulats', function ($q) use ($consulats) {
        //     $q->whereIn('zen_consulat.id', $consulats);
        // })->orWhereHas('ministeres.consulats', function ($q) use ($consulats) {
        //     $q->whereIn('zen_consulat.id', $consulats);
        // });
    }
}
