<?php

namespace App\Http\Controllers;

use App\Models\AffectationBureauPasserelle;
use App\Models\Bureau;
use App\Models\EntiteDiplomatique;
use App\Models\Passerelle;
use App\Shared\Controllers\BaseController;
use App\Traits\PasserelleTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasserelleController extends BaseController
{
    use PasserelleTrait;
    protected $model = Passerelle::class;
    protected $validation = [
        'libelle' => 'required',
        'type' => 'required|integer|exists:zen_type_passerelle,id',
        'passe_frontiere' => 'required|integer|exists:zen_passe_frontiere,id',
        'pays_origine' => 'required|integer|exists:pays,id',
        'pays_siege' => 'required|integer|exists:pays,id',
        'description' => '',
        'bureau' => 'integer|exists:zen_bureau,id'
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, $this->validation);
        $entiteDiplomatique = EntiteDiplomatique::add($validated);
        $passerelle = $this->model::create([
            'entite_diplomatique' => $entiteDiplomatique->id,
            'passe_frontiere' => $request->passe_frontiere,
            'type' => $request->type,
            'inscription' => Auth::id()
        ]);




        return $this->model::find($passerelle->id);
    }


    public function affecter(Request $request)
    {
        $validated = $this->validate($request, [
            'bureau' => 'required|integer|exists:zen_bureau,id',
            'passerelle' => 'required|integer|exists:zen_passerelle,id'
        ]);


        AffectationBureauPasserelle::create([
            'passerelle' => $validated['passerelle'],
            'bureau' => $validated['bureau'],
            'inscription' => Auth::id()
        ]);

        return Bureau::find($validated['bureau']);
    }

    public function update(Request $request, $id)
    {
        $validated = $this->validate($request, $this->validation);
        $passerelle = $this->model::findOrFail($id);
        EntiteDiplomatique::edit($passerelle->entite_diplomatique, $validated);
        $passerelle->update($validated);
    }


    public function getByPays(Request $request, $pays)
    {
        $passerelles =  $this->filterByPays($this->modelQuery, [$pays]);
        return $this->refineData($passerelles, $request)->with('type', 'passe_frontiere')->latest()->get()->each->append('bureau');
    }



    public function show($id)
    {
        return $this->model::find($id)->append('bureau');
    }
}
