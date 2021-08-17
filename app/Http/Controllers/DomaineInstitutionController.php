<?php

namespace App\Http\Controllers;

use App\Models\AffectationDomaineAmbassade;
use App\Models\AffectationDomaineMinistere;
use App\Models\DomaineInstitution;
use App\Shared\Controllers\BaseController;
use App\Traits\DomaineTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DomaineInstitutionController extends BaseController
{
    use DomaineTrait;
    protected $model = DomaineInstitution::class;
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

        $domaine = $this->model::create(array_merge($request->all(), ['inscription' => Auth::id()]));

        if ($request->has('ministere')) {
            AffectationDomaineMinistere::create(['domaine' => $domaine->id, 'ministere' => $request->ministere, 'inscription' => Auth::id()]);
        } else if ($request->has('ambassade')) {
            AffectationDomaineAmbassade::create(['domaine' => $domaine->id, 'ambassade' => $request->ambassade, 'inscription' => Auth::id()]);
        }

        return $domaine;
    }

    public function getByAmbassade(Request $request, $ambassade)
    {
        $domaines = $this->model::whereHas('ambassades', function ($q) use ($ambassade) {
            $q->where('zen_ambassade.id', $ambassade);
        });

        return $this->refineData($domaines, $request)->latest()->get();
    }


    public function getByMinistere(Request $request, $ministere)
    {
        $domaines = $this->model::whereHas('ministeres', function ($q) use ($ministere) {
            $q->where('zen_ministere.id', $ministere);
        });

        return $this->refineData($domaines, $request)->latest()->get();
    }
}
