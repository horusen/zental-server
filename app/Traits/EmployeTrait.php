<?php

namespace App\Traits;


trait EmployeTrait
{
    use BaseTrait;

    protected function filterByBureaux($employes, $bureaux)
    {
        return $employes->whereHas('bureaux', function ($q) use ($bureaux) {
            $q->whereIn('zen_bureau.id', $bureaux);
        });
    }

    protected function search($employes, $keyword)
    {
        return $employes->whereHas('employe', function ($q) use ($keyword) {
            $q->where('prenom', 'like', '%' . $keyword . '%')->orWhere('prenom', 'like', '%' . $keyword . '%');
        });
    }

    public function filterByMinisteres($employes, $ministeres)
    {
        return $employes->whereHas('services.ministeres', function ($q) use ($ministeres) {
            $q->whereIn('zen_ministere.id', $ministeres);
        });
    }



    public function filterByPostes($employes, $postes)
    {
        return $employes->whereIn('poste', $postes);
    }


    public function filterByFonctions($employes, $fonctions)
    {
        return $employes->whereIn('fonction', $fonctions);
    }


    public function filterByDomaines($employes, $domaines)
    {
        return $employes->whereHas('services.departement.domaine', function ($q) use ($domaines) {
            $q->whereIn('exp_domaine.id', $domaines);
        });
    }


    public function filterByServices($employes, $services)
    {
        return $employes->whereHas('services', function ($q) use ($services) {
            $q->whereIn('zen_service.id', $services);
        });
    }


    public function filterByDepartements($employes, $departements)
    {
        return $employes->whereHas('services.departement', function ($q) use ($departements) {
            $q->whereIn('zen_departement.id', $departements);
        });
    }


    public function filterByAmbassades($employes, $ambassades)
    {
        return $employes->whereHas('services.ambassades', function ($q) use ($ambassades) {
            $q->whereIn('zen_ambassade.id', $ambassades);
        });
    }



    public function filterByConsulats($employes, $consulats)
    {
        return $employes->whereHas('services.consulats', function ($q) use ($consulats) {
            $q->whereIn('zen_consulat.id', $consulats);
        });
    }
}
