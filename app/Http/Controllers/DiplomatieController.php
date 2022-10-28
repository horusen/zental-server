<?php

namespace App\Http\Controllers;

use App\Models\Pays;
use App\Shared\Controllers\BaseController;
use App\Traits\DiplomatieTrait;
use Illuminate\Http\Request;

class DiplomatieController extends BaseController
{
    use DiplomatieTrait;

    protected $model = Pays::class;
    protected $validation = [];


    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }


    /**
     * Retourne la liste de tous les pays qui ont une entite diplomatique
     * dont le pays d'origine est le pays spécifié en paramètre
     */
    public function getByPays(Request $request, $pays)
    {
        $diplomaties = $this->filterByPays($this->modelQuery, $pays);
        return $this->refineData($diplomaties, $request)->get();
    }


    public function getAilleursByPays(Request $request, $pays)
    {
        $diplomaties = $this->filterAilleursByPays($this->modelQuery, $pays);
        return $this->refineData($diplomaties, $request)->get();
    }
}
