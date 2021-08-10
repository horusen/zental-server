<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait MembreCabinetMinistreTrait
{
    use BaseTrait;
    protected function filterByMinistres($membres, $ministres)
    {
        return $membres->whereIn('ministre', $ministres);
    }

    protected function filterByPostes($membres, $postes)
    {
        return $membres->whereHas('poste', function ($q) use ($postes) {
            $q->whereIn('zen_poste.id', $postes);
        });
    }

    protected function filterByFonctions($membres, $fonctions)
    {
        return $membres->whereHas('fonction', function ($q) use ($fonctions) {
            $q->whereIn('zen_fonction.id', $fonctions);
        });
    }

    protected function filterByDomaines($membres, $domaines)
    {
        return $membres->whereHas('poste.domaine', function ($q) use ($domaines) {
            $q->whereIn('exp_domaine.id', $domaines);
        });
    }

    protected function filterBySexes($membres, $sexes)
    {
        return $membres->whereHas('membre', function ($q) use ($sexes) {
            $q->whereIn('sexe', $sexes);
        });
    }



    public function filterNonMembresCabinet($membres, $ministres)
    {
        return $membres->whereNotIn('ministre', $ministres);
    }

    public function search($membres, $keyword)
    {
        return $membres->whereHas('membre', function ($q) use ($keyword) {
            $q->where('prenom', 'like', '%' . $keyword . '%')->orWhere('nom', 'like', '%' . $keyword . '%');
        });
    }



    public function filter($membres, $filtering_params)
    {
        if (isset($filtering_params['postes'])) {
            $membres = $this->filterByPostes($membres, $filtering_params['postes']);
        }

        if (isset($filtering_params['fonctions'])) {
            $membres = $this->filterByFonctions($membres, $filtering_params['fonctions']);
        }

        if (isset($filtering_params['domaines'])) {
            $membres = $this->filterByDomaines($membres, $filtering_params['domaines']);
        }

        if (isset($filtering_params['sexes'])) {
            $membres = $this->filterBySexes($membres, $filtering_params['sexes']);
        }

        if (isset($filtering_params['ministres'])) {
            $membres = $this->filterByMinistres($membres, $filtering_params['ministres']);
        }

        return $membres;
    }
}
