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
        'type' => 'required|integer|exists:zen_type_passerelle,id',
        'passe_frontiere' => 'required|integer|exists:zen_passe_frontiere,id',
        'pays_origine' => 'required|integer|exists:pays,id',
        'pays_siege' => 'required|integer|exists:pays,id',
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }


    public function getAllData(Request $request)
    {
        return $this->refineData($this->modelQuery, $request)->latest()->get();
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validation);

        $passerelle = $this->model::create($request->all() + ['inscription' => Auth::id()]);

        return $this->model::find($passerelle->id);
    }


    public function affecter(Request $request)
    {
        $this->validate($request, [
            'bureau' => 'required|integer|exists:zen_bureau,id',
            'passerelle' => 'required|integer|exists:zen_passerelle,id'
        ]);

        $bureau = Bureau::find($request->bureau);
        $passerelle = $this->model::find($request->passerelle);

        AffectationBureauPasserelle::create([
            'passerelle' => $passerelle->id,
            'bureau' => $bureau->id,
            'inscription' => Auth::id()
        ]);


        EntiteDiplomatique::edit($bureau->entite_diplomatique, ['pays_siege' => $passerelle->pays_siege]);

        return $bureau->refresh();
    }



    public function getByPays(Request $request, $pays)
    {
        $passerelles =  $this->filterByOrigine($this->modelQuery, [$pays]);
        return $this->refineData($passerelles, $request)->with('type', 'passe_frontiere', 'pays_siege')->latest()->get()->each->append('bureau');
    }


    public function getNonAffecteByPays(Request $request, $pays)
    {
        $passerelles =  $this->filterByOrigine($this->modelQuery, [$pays]);
        $passerelles = $this->filterByNonAffectation($passerelles);
        return $this->refineData($passerelles, $request)->with('type', 'passe_frontiere', 'pays_siege')->latest()->get()->each->append('bureau');
    }

    public function show($id)
    {
        return $this->model::findOrFail($id)->append('bureau');
    }
}
