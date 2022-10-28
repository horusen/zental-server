<?php

namespace App\Http\Controllers;

use App\Models\AffectationAmbassadeMinistere;
use App\Models\Ambassade;
use App\Models\EntiteDiplomatique;
use App\Models\Ministere;
use App\Shared\Controllers\BaseController;
use App\Traits\MinistereTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MinistereController extends BaseController
{
    use MinistereTrait;
    protected $model = Ministere::class;
    protected $validation = [
        'libelle' => 'required',
        'pays_origine' => 'required|integer|exists:pays,id',
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }

    // get by data
    public function getAllData(Request $request)
    {
        return $this->refineData($this->modelQuery, $request)->latest()->get();
    }

    public function getByCurrentUser()
    {
        return $this->model::where('inscription', Auth::id())->latest()->get();
    }


    public function store(Request $request)
    {
        $this->validate($request, $this->validation);
        $request['pays_siege'] = $request->pays_origine;
        $entiteDiplomatique = EntiteDiplomatique::add($request->all());
        $ministere = $this->model::create(['entite_diplomatique' => $entiteDiplomatique->id, 'inscription' => Auth::id()]);

        // Affecte all ambassade with the same pays_origine
        $ambassades = Ambassade::whereHas('entite_diplomatique', function ($q) use ($entiteDiplomatique) {
            $q->where('pays_origine', $entiteDiplomatique->pays_origine);
        });

        foreach ($ambassades as $ambassade) {
            AffectationAmbassadeMinistere::create([
                'ministere' => $ministere->id,
                'ambassade' => $ambassade->id,
                'inscription' => Auth::id()
            ]);
        }

        return $this->model::findOrFail($ministere->id);
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, $this->validation);
        $ambassade = $this->model::findOrFail($id);
        EntiteDiplomatique::edit($ambassade->entite_diplomatique, $request->all());
        return $this->model::findOrFail($id);
    }
}
