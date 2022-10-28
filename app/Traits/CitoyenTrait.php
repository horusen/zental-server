<?php

use App\Traits\BaseTrait;

namespace App\Traits;

trait CitoyenTrait
{
    use BaseTrait;


    protected function search($users, $keyword)
    {
        return $users->where('prenom', 'like', '%' . $keyword . '%');
        // ->orWhere('nom', 'like', '%' . $keyword . '%');
    }

    public function filterByEtats($citoyens, $etats)
    {
        return $citoyens->whereHas('estCitoyens', function ($q) use ($etats) {
            $q->whereIn('zen_inscriptions_consulaires.id', $etats);
        });
    }

    public function filterByLiaisons($citoyens, $liaisons)
    {
        return $citoyens->whereHas('estCitoyens.liaisons', function ($q) use ($liaisons) {
            $q->whereIn('zen_liaison.id', $liaisons);
        });
    }


    public function filterByAmbassades($citoyens, $ambassades)
    {
        return $citoyens->whereHas('estCitoyens.ambassades', function ($q) use ($ambassades) {
            $q->whereIn('zen_ambassade.id', $ambassades);
        })->orWhereHas('estCitoyens.consulats.ambassades', function ($q) use ($ambassades) {
            $q->whereIn('zen_consulat.id', $ambassades);
        });
    }


    public function filterByConsulats($citoyens, $consulats)
    {
        return $citoyens->whereHas('estCitoyens.consulats', function ($q) use ($consulats) {
            $q->whereIn('zen_consulat.id', $consulats);
        });
    }

    public function filterByPays($citoyens, $pays)
    {
        return $citoyens->whereHas('estCitoyens.ambassades.entite_diplomatique', function ($q) use ($pays) {
            $q->whereIn('zen_entite_diplomatique.pays_origine', $pays);
        })->orWhereHas('estCitoyens.consulats.entite_diplomatique', function ($q) use ($pays) {
            $q->whereIn('zen_entite_diplomatique.pays_origine', $pays);
        })->orWhereHas('estCitoyens.liaisons.bureaux.entite_diplomatique', function ($q) use ($pays) {
            $q->whereIn('zen_entite_diplomatique.pays_origine', $pays);
        });
    }
}
