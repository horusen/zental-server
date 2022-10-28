<?php

namespace App\Http\Controllers;

use App\Models\Groupe;
use App\Models\MembreGroupe;
use App\Shared\Controllers\BaseController;
use App\Traits\GroupeTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupeController extends BaseController
{
    use GroupeTrait;

    protected $model = Groupe::class;
    protected $validation = [
        'libelle' => 'required',
        'description' => 'required'
    ];


    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }


    public function store(Request $request)
    {
        $request->validate($this->validation);
        $groupe = $this->model::create($request->all() + ['inscription' => Auth::id()]);

        MembreGroupe::create(['membre' => Auth::id(), 'groupe' => $groupe->id, 'inscription' => Auth::id(), 'admin' => 1]);

        return $this->model::find($groupe->id);
    }


    public function getByUserAsMembre(Request $request, $user)
    {
        $groupes = $this->filterByUserAsMembre($this->modelQuery, $user);
        return $this->refineData($groupes, $request)->latest()->get();
    }


    public function getByUserAsNonMembre(Request $request, $user)
    {
        $groupes = $this->filterByUserAsNonMembre($this->modelQuery, $user);
        return $this->refineData($groupes, $request)->latest()->get();
    }
}
