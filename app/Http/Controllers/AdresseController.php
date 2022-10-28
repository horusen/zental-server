<?php

namespace App\Http\Controllers;

use App\Models\Addresse;
use App\Models\AffectationAdresseEntiteDiplomatique;
use App\Models\AffectationAdresseMinistere;
use App\Shared\Controllers\BaseController;
use App\Traits\AdresseTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdresseController extends BaseController
{
    use AdresseTrait;
    protected $model = Addresse::class;
    protected $validation = [
        'ville' => 'required|integer|exists:ville,id_ville',
        'entite_diplomatique' => 'required_without:user|integer|exists:zen_entite_diplomatique,id',
        'user' => 'required_without:entite_diplomatique|integer|exists:cpt_inscription,id_inscription',
        'addresse' => 'required',
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }



    public function update(Request $request, $id)
    {
        $this->isValid($request);

        $addresse = $this->model::findOrFail($id);
        $addresse->delete();
        return $this->store($request);
    }


    public function store(Request $request)
    {
        $validated = $this->isValid($request);
        $addresse = $this->model::create(array_merge($validated, ['inscription' => Auth::id()]));

        if ($request->has('entite_diplomatique')) {
            AffectationAdresseEntiteDiplomatique::create(['entite_diplomatique' => $request->entite_diplomatique, 'addresse' => $addresse->id, 'inscription' => Auth::id()]);
        } else if ($request->has('user')) {
            $user = User::find($request->user);
            if (isset($user->addresse)) {
                $user->addresse()->delete();
            }

            $user->update(['addresse' => $addresse->id]);
        }
        return $this->model::find($addresse->id);
    }


    public function getByMinistere($ministere)
    {
        return $this->filterByMinisteres($this->modelQuery, [$ministere])->latest()->get();
    }


    public function getByBureau($bureau)
    {
        return $this->filterByBureaux($this->modelQuery, [$bureau])->latest()->get();
    }


    public function getByUser($user)
    {
        return $this->filterByUser($this->modelQuery, [$user])->latest()->get();
    }


    public function getByAmbassade($ambassade)
    {
        return $this->filterByAmbassades($this->modelQuery, [$ambassade])->latest()->get();
    }


    public function getByConsulat($consulat)
    {
        return $this->filterByConsulats($this->modelQuery, [$consulat])->latest()->get();
    }
}
