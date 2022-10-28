<?php

namespace App\Traits;

trait PasserelleTrait
{
    use BaseTrait;

    // filter by siege
    public function filterByPaysSiege($passerelles, $pays)
    {
        return $passerelles->whereHas('pays_siege', function ($q) use ($pays) {
            $q->where('pays.id', $pays);
        });
    }

    // filter by origin
    public function filterByOrigine($passerelles, $pays)
    {
        return $passerelles->whereHas('pays_origine', function ($q) use ($pays) {
            $q->where('pays.id', $pays);
        });
    }

    // fitler by no affectation - - - - - - filter by non affectattion
    public function filterByNonAffectation($passerelles)
    {
        return $passerelles->doesntHave('bureaux');
    }
}
