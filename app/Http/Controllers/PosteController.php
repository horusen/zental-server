<?php

namespace App\Http\Controllers;

use App\Models\AffectationPosteAmbassade;
use App\Models\AffectationPosteMinistere;
use App\Models\Poste;
use App\Shared\Controllers\BaseController;
use App\Traits\PosteTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PosteController extends BaseController
{
    use PosteTrait;
    protected $model = Poste::class;
    protected $validation = [
        'libelle' => 'required',
        'description' => '',
        'domaine' => 'required|integer|exists:exp_domaine,id',
        'ministere' => 'required_without:ambassade|integer|exists:zen_ministere,id',
        'ambassade' => 'required_without:ministere|integer|exists:zen_ambassade,id'
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }

    public function getAll()
    {
        return $this->model::whereNotIn('id', [1, 2, 3])->get();
    }


    public function getByMinistere(Request $request, $ministere)
    {
        $postes = $this->filterByMinisteres($this->modelQuery, [$ministere]);
        return $this->refineData($postes, $request)->latest()->get();
    }


    public function getByAmbassade(Request $request, $ambassade)
    {
        $postes = $this->filterByAmbassades($this->modelQuery, [$ambassade]);
        return $this->refineData($postes, $request)->latest()->get();
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, $this->validation);
        $poste = $this->model::create(array_merge($validated, ['inscription' => Auth::id()]));

        if ($request->has('ministere')) {

            AffectationPosteMinistere::create(['ministere' => $request->ministere, 'poste' => $poste->id, 'inscription' => Auth::id()]);
        } else  if ($request->has('ambassade')) {

            AffectationPosteAmbassade::create(['ambassade' => $request->ambassade, 'poste' => $poste->id, 'inscription' => Auth::id()]);
        }


        return $poste;
    }
}
