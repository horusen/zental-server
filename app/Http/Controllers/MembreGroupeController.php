<?php

namespace App\Http\Controllers;

use App\Models\MembreGroupe;
use App\Shared\Controllers\BaseController;
use App\Traits\MembreGroupeTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembreGroupeController extends BaseController
{
    use MembreGroupeTrait;
    protected $model = MembreGroupe::class;
    protected $validation = [
        'membres' => 'required|array',
        'membres.*' => 'required|integer|exists:cpt_inscription,id_inscription',
        'groupe' => 'required|integer|exists:zen_groupe,id',
    ];


    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }

    public function store(Request $request)
    {
        $request->validate($this->validation);
        $idMembres = [];
        foreach ($request->membres as $membre) {
            $membreship = $this->model::create([
                'membre' => $membre,
                'groupe' => $request->groupe,
                'admin' => false,
                'inscription' => Auth::id()
            ]);

            array_push($idMembres, $membreship->id);
        }

        return $this->model::find($idMembres);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'admin' => 'required|boolean',
            'membre' => 'required|integer|exists:cpt_inscription,id_inscription',
            'groupe' => 'required|integer|exists:zen_groupe,id',
        ]);

        $membre = $this->model::find($id);
        $membre->update($request->all());
        return $membre->refresh();
    }


    public function getByGroupe(Request $request, $groupe)
    {
        $membres = $this->filterByGroupe($this->modelQuery, $groupe);
        return $this->refineData($membres, $request)->get();
    }
}
