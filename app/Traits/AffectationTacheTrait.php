<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait AffectationTacheTrait
{
    public function getAffectationByDomaine($affectations, $domaines)
    {
        return $affectations->whereHas('tache', function ($q) use ($domaines) {
            return $this->getAffectationByDomaine($q, $domaines);
        });
    }

    public function getAffectationByNiveau($affectations, $niveaux)
    {
    }

    public function getAffectationByNiveauDifficulte($affectations, $niveauxDifficultes)
    {
    }

    public function getAffectationByLangue($affectations, $langues)
    {
    }

    public function getAffectationBySousDomaine($affectations, $sousDomaines)
    {
    }

    public function getAffectationByMotCle($affectations, $motCles)
    {
    }

    public function getAffectationQueJAiAssigne($affectations)
    {
    }

    public function getAffectationByQuiMeSontAssigne($affectations)
    {
    }

    public function filterByKeyword($affectations, $keyword)
    {
        return  $affectations
            ->whereHas('tache', function ($q) use ($keyword) {
                $q->where('libelle', 'like', '%' . $keyword . '%');
            })
            ->orWhereHas('groupe', function ($q) use ($keyword) {
                $q->where('libelle', 'like', '%' . $keyword . '%');
            })
            ->orWhereHas('eleve', function ($q) use ($keyword) {
                $q->where('prenom', 'like', '%' . $keyword . '%')->orWhere('nom', 'like', '%' . $keyword . '%');
            })
            ->orWhereHas('professeur', function ($q) use ($keyword) {
                $q->where('prenom', 'like', '%' . $keyword . '%')->orWhere('nom', 'like', '%' . $keyword . '%');
            });
    }

    public function filterByEleve($affectations, $eleve)
    {
        return $affectations
            ->where('eleve', $eleve)
            ->orWhereHas('groupe.membres', function ($q) use ($eleve) {
                $q->where('membre', $eleve);
            });
    }

    public function filterByLangues($affectations, $langues)
    {
        return $affectations->whereHas('tache.langue', function ($q) use ($langues) {
            return $q->whereIn('exp_langue.id', $langues);
        });
    }

    public function filterByNiveaux($affectations, $niveaux)
    {
        return $affectations->whereHas('tache.niveau', function ($q) use ($niveaux) {
            return $q->whereIn('exp_niveau.id', $niveaux);
        });
    }


    public function filterBySousDomaines($affectations, $sous_domaines)
    {
        return $affectations->whereHas('tache.sous_domaine', function ($q) use ($sous_domaines) {
            return $q->whereIn('exp_sous_domaine.id', $sous_domaines);
        });
    }


    public function filterByDomaines($affectations, $sous_domaines)
    {
        return $affectations->whereHas('tache.sous_domaine.domaine', function ($q) use ($sous_domaines) {
            return $q->whereIn('exp_domaine.id', $sous_domaines);
        });
    }



    public function filterByMotCles($affectations, $motCles)
    {
        return $affectations->whereHas('tache.motcles', function ($q) use ($motCles) {
            return $q->whereIn('exp_mot_cle.id', $motCles);
        });
    }

    public function filterByNiveauxDifficultes($affectations, $nd)
    {
        return $affectations->whereHas('tache.niveau_difficulte', function ($q) use ($nd) {
            return $q->whereIn('exp_niveau_difficulte.id', $nd);
        });
    }

    public function filterByProfesseurs($affectations, $professeurs)
    {
        return $affectations->whereIn('professeur', $professeurs);
    }

    public function filterByPeriodes($affectations, $periodes)
    {
        return $affectations->whereIn('periode', $periodes);
    }

    public function filterByGroupes($affectations, $groupes)
    {
        return $affectations->whereIn('groupe', $groupes);
    }





    private function filter($affectations, $filteringParams)
    {
        if (isset($filteringParams['sous_domaines'])) {
            $affectations = $this->filterBySousDomaines($affectations, $filteringParams['sous_domaines']);
        }

        if (isset($filteringParams['niveaux'])) {
            $affectations = $this->filterByNiveaux($affectations, $filteringParams['niveaux']);
        }

        if (isset($filteringParams['langues'])) {
            $affectations = $this->filterByLangues($affectations, $filteringParams['langues']);
        }

        if (isset($filteringParams['niveau_difficultes'])) {
            $affectations = $this->filterByNiveauxDifficultes($affectations, $filteringParams['niveau_difficultes']);
        }

        if (isset($filteringParams['mot_cles'])) {
            $affectations = $this->filterByMotCles($affectations, $filteringParams['mot_cles']);
        }

        if (isset($filteringParams['groupes'])) {
            $affectations = $this->filterByGroupes($affectations, $filteringParams['groupes']);
        }

        if (isset($filteringParams['professeurs'])) {
            $affectations = $this->filterByProfesseurs($affectations, $filteringParams['professeurs']);
        }

        if (isset($filteringParams['periodes'])) {
            $affectations = $this->filterByPeriodes($affectations, $filteringParams['periodes']);
        }



        return $affectations;
    }


    public function filterByAssigneAuUser($affectations)
    {
        return $affectations->whereHas('eleve', function ($q) {
            $q->where('eleve', Auth::id());
        })->orWhereHas('groupe.membres', function ($q) {
            $q->where('membre', Auth::id());
        });
    }

    public function filterByAssigneParUser($affectations)
    {
        return $affectations->whereHas('professeur', function ($q) {
            return $q->where('professeur', Auth::id());
        });
    }

    protected function applyFilter($affectations, Request $request)
    {
        if ($request->has('filter')) {
            $filteringParams = json_decode($request->filter, true);
            return $this->filter($affectations, $filteringParams);
        }

        return $affectations;
    }

    protected function search($taches, $keyword)
    {
        return $taches->whereHas('tache', function ($q) use ($keyword) {
            $q->where('libelle', 'like', '%' . $keyword . '%');
        });
    }

    protected function applySearch($taches, $request)
    {
        if ($request->has('search')) {
            return $this->search($taches, $request->input('search'));
        }

        return $taches;
    }


    protected function refineData(Request $request, $affectations)
    {
        $affectations = $this->applyFilter($affectations,  $request);
        $affectations = $this->applySearch($affectations,  $request);
        return $affectations;
    }



    // public function applyFilter($affectations, Request $request)
    // {
    //     if ($request->has('keyword')) {
    //         $this->filterByKeyword($affectations, $request->input('keyword'));
    //     }

    //     return $affectations;
    // }
}
