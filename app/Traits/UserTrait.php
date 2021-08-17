<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait UserTrait
{
    public function filterByNotInClasse($users, $classe)
    {
        return $users->whereDoesntHave('estDansClasses', function ($q) use ($classe) {
            $q->where('exp_classe.id', $classe);
        });
    }


    protected function filterByTypes($users, $types)
    {
        if (in_array("etudiant", $types)) {
            return $users->has("eleves");
        } else if (in_array("professeur", $types)) {
            return $users->has('estProfesseurs');
        }

        return $users;
    }


    protected function filterByNonRelation($users, $user)
    {
        return $users->whereDoesntHave('relations_interpersonnelles', function ($q) use ($user) {
            $q->where('zen_relation_interpersonnelle.id', $user);
        });
    }


    protected function filterByNonContact($users, $user)
    {
        return $users->whereDoesntHave('contacts', function ($q) use ($user) {
            $q->where('zen_contact_user.user', $user);
        });
    }


    protected function filterByNonMembreCabinetMinistre($users, $ministres)
    {
        return $users->whereDoesntHave('membresCabinetMinistre', function ($q) use ($ministres) {
            $q->whereNotIn('zen_membre_cabinet_ministre.ministre', $ministres);
        });
    }


    protected function filterMembreFamilleByTypeRelationFamiliale($users, $user, $type_relation_familiale)
    {
        // return $users->has('relations_familiales');
        return $users->whereHas('relations_familiales', function ($q) use ($user, $type_relation_familiale) {
            $q->whereHas('type', function ($q) use ($type_relation_familiale) {
                $q->where('libelle', $type_relation_familiale);
            })->where('user', $user);
        });
    }



    protected function filterByNonMembresFamilles($users, $user)
    {;
        return $users->whereDoesntHave('relations_familiales', function ($q) use ($user) {
            $q->where('zen_relation_familiale.user',  $user);
        });
    }


    protected function filterByDomaines($users, $domaines)
    {
        return $users->whereHas('membre_sous_reseaux.sous_domaine', function ($q) use ($domaines) {
            return $q->whereIn('exp_sous_domaine.domaine', $domaines);
        });
    }


    protected function filterBySousDomaines($users, $sous_domaines)
    {
        return $users->whereHas('membre_sous_reseaux', function ($q) use ($sous_domaines) {
            $q->whereIn('exp_membre_sous_reseau.sous_reseau', $sous_domaines);
        });
    }


    public function filterByNonEmployesDansServices($users, $services)
    {
        return $users->whereDoesntHave('employes.affectation_services', function ($q) use ($services) {
            $q->whereNotIn('service', $services);
        });
    }


    protected function filter($users, $filteringParams)
    {

        if (isset($filteringParams['types'])) {
            $users = $this->filterByTypes($users, $filteringParams['types']);
        }

        if (isset($filteringParams['domaines'])) {
            $users = $this->filterByDomaines($users, $filteringParams['domaines']);
        }


        if (isset($filteringParams['sous_domaines'])) {
            $users = $this->filterBySousDomaines($users, $filteringParams['sous_domaines']);
        }


        return $users;
    }

    protected function applyFilter($users, Request $request)
    {
        if ($request->has('filter')) {
            $filteringParams = json_decode($request->filter, true);
            return $this->filter($users, $filteringParams);
        }

        return $users;
    }


    protected function search($users, $keyword)
    {
        return $users->where('prenom', 'like', '%' . $keyword . '%')->orWhere('prenom', 'like', '%' . $keyword . '%');
    }

    protected function applySearch($users, $request)
    {
        if ($request->has('search')) {
            return $this->search($users, $request->input('search'));
        }

        return $users;
    }

    protected function refineData($users, $request)
    {
        $users = $this->applySearch($users, $request);
        $users = $this->applyFilter($users, $request);
        return $users;
    }
}
