<?php

namespace App\Traits;

trait ResponsableEntiteTrait
{
    use BaseTrait;

    public function filterMinistreEnFonction($responsables, $ministere)
    {
        return $responsables->whereHas('affectation_ministeres', function ($q) use ($ministere) {
            $q->where('ministere', $ministere)->where('en_fonction', true);
        });
    }


    public function filterAmbassaadeurEnFonction($responsables, $ambassade)
    {
        return $responsables->whereHas('affectation_ambassades', function ($q) use ($ambassade) {
            $q->where('ambassade', $ambassade)->where('en_fonction', true);
        });
    }


    protected function search($employes, $keyword)
    {
        return $employes->whereHas('employe', function ($q) use ($keyword) {
            $q->where('prenom', 'like', '%' . $keyword . '%')->orWhere('prenom', 'like', '%' . $keyword . '%');
        });
    }


    public function filterConsuleEnFonction($responsables, $consulat)
    {
        return $responsables->whereHas('affectation_consulats', function ($q) use ($consulat) {
            $q->where('consulat', $consulat)->where('en_fonction', true);
        });
    }



    public function filterByMinisteres($responsables, $ministeres, $en_fonction)
    {
        return $responsables->whereHas('affectation_ministeres', function ($q) use ($ministeres, $en_fonction) {
            $q->whereIn('ministere', $ministeres)->where('en_fonction', $en_fonction);
        });
    }


    public function filterByAmbassades($responsables, $ambassades, $en_fonction = false)
    {
        return $responsables->whereHas('affectation_ambassades', function ($q) use ($ambassades, $en_fonction) {
            $q->whereIn('ambassade', $ambassades)->where('en_fonction', $en_fonction);
        });
    }


    public function filterByConsulats($responsables, $consulats, $en_fonction = false)
    {
        return $responsables->whereHas('affectation_consulats', function ($q) use ($consulats, $en_fonction) {
            $q->whereIn('consulat', $consulats)->where('en_fonction', $en_fonction);
        });
    }
}
