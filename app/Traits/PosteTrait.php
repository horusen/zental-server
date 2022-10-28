<?php

namespace App\Traits;

trait PosteTrait
{
    use BaseTrait;

    // Filter by bureau
    public function filterByBureaux($postes, $bureaux)
    {
        return $postes->whereHas('bureaux', function ($q) use ($bureaux) {
            $q->whereIn('zen_bureau.id', $bureaux);
            // })->orWhereHas('consulats.bureaux', function ($q) use ($postes) {
            //     $q->whereIn('zen_bureau.id', $postes);
            // })->orWhereHas('ambassades.consulats.bureaux', function ($q) use ($postes) {
            //     $q->whereIn('zen_bureau.id', $postes);
            // })->orWhereHas('ministere.ambassades.consulats.bureaux', function ($q) use ($postes) {
            //     $q->whereIn('zen_bureau.id', $postes);
            // })->orWhereHas('ambassades.bureaux', function ($q) use ($postes) {
            //     $q->whereIn('zen_bureau.id', $postes);
            // })->orWhereHas('ministeres.ambassades.bureaux', function ($q) use ($postes) {
            //     $q->whereIn('zen_bureau.id', $postes);
            // })->orWhereHas('ministeres.bureaux', function ($q) use ($postes) {
            //     $q->whereIn('zen_bureau.id', $postes);
        });
    }

    // Filter by ministere
    public function filterByMinisteres($postes, $ministeres)
    {
        return $postes->whereHas('ministeres', function ($q) use ($ministeres) {
            $q->whereIn('zen_ministere.id', $ministeres);
        });
    }


    // Filter by ambassade
    public function filterByAmbassades($postes, $ambassades)
    {
        return $postes->whereHas('ambassades', function ($q) use ($ambassades) {
            $q->whereIn('zen_ambassade.id', $ambassades);
        })->orWhereHas('ministeres.ambassades', function ($q) use ($ambassades) {
            $q->whereIn('zen_ambassade.id', $ambassades);
        });;
    }


    // Filter by service
    public function filterByServices($postes, $services)
    {
        return $postes->whereHas('ministeres.services', function ($q) use ($services) {
            $q->whereIn('zen_service.id', $services);
        })->orWhereHas('ambassades.services', function ($q) use ($services) {
            $q->whereIn('zen_service.id', $services);
        })->orWhereHas('consulats.services', function ($q) use ($services) {
            $q->whereIn('zen_service.id', $services);
        })->orWhereHas('bureaux.services', function ($q) use ($services) {
            $q->whereIn('zen_service.id', $services);
        });
    }


    // filter by consulat
    public function filterByConsulats($postes, $consulats)
    {
        return $postes->whereHas('consulats', function ($q) use ($consulats) {
            $q->whereIn('zen_consulat.id', $consulats);
        });

        // ->orWhereHas('ambassades.consulats', function ($q) use ($consulats) {
        //     $q->whereIn('zen_consulat.id', $consulats);
        // })->orWhereHas('ministeres.ambassades.consulats', function ($q) use ($consulats) {
        //     $q->whereIn('zen_consulat.id', $consulats);
        // })->orWhereHas('ministeres.consulats', function ($q) use ($consulats) {
        //     $q->whereIn('zen_consulat.id', $consulats);
        // });
    }
}
