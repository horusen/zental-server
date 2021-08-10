<?php

namespace App\Http\Controllers;

use App\Models\AffectationFonctionAmbassade;
use App\Models\AffectationFonctionMinistere;
use App\Models\Fonction;
use App\Shared\Controllers\BaseController;
use App\Traits\FonctionTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FonctionController extends BaseController
{
    use FonctionTrait;
    protected $model = Fonction::class;
    protected $validation = [
        'libelle' => 'required',
        'ministere' => 'required_without:ambassade|integer|exists:zen_ministere,id',
        'ambassade' => 'required_without:ministere|integer|exists:zen_ambassade,id'
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }

    public function store(Request $request)
    {
        $this->isValid($request, $this->validation);

        $fonction = Fonction::create(array_merge($request->all(), ['inscription' => Auth::id()]));

        if ($request->has('ministere')) {
            AffectationFonctionMinistere::create(['fonction' => $fonction->id, 'ministere' => $request->ministere, 'inscription' => Auth::id()]);
        } else if ($request->has('ambassade')) {
            AffectationFonctionAmbassade::create(['fonction' => $fonction->id, 'ambassade' => $request->ambassade, 'inscription' => Auth::id()]);
        }

        return $fonction;
    }

    public function getByAmbassade(Request $request, $ambassade)
    {
        $fonctions = $this->model::whereHas('ambassades', function ($q) use ($ambassade) {
            $q->where('zen_ambassade.id', $ambassade);
        });

        return $this->refineData($fonctions, $request)->latest()->get();
    }


    public function getByMinistere(Request $request, $ministere)
    {
        $fonctions = $this->model::whereHas('ministeres', function ($q) use ($ministere) {
            $q->where('zen_ministere.id', $ministere);
        });

        return $this->refineData($fonctions, $request)->latest()->get();
    }
}
