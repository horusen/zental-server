<?php

namespace App\Http\Controllers;

use App\Models\MinistreGouvernement;
use App\Shared\Controllers\BaseController;
use App\Traits\FileHandlerTrait;
use App\Traits\MinistreGouvernementTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MinistreGouvernementController extends BaseController
{
    use FileHandlerTrait, MinistreGouvernementTrait;

    // Don't forget to extends BaseController
    protected $model = MinistreGouvernement::class;
    protected $validation = [
        'prenom' => 'required',
        'nom' => 'required',
        'pays' => 'required|integer|exists:pays,id',
        'titre' => 'required',
    ];


    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }


    public function store(Request $request) {

        $request->validate($this->validation);


        $ministre = $this->model::create($request->except('photo') + ['inscription' => Auth::id()]);

        $fichier = $this->storeImageFile($request->photo, 'pays/' . $request->pays . '/ministre');

        $ministre->update(['photo' => $fichier->id]);

        return $this->model::find($ministre->id);

    }


    public function update(Request $request, $id){

      $request->validate($this->validation);

      $ministre = $this->model::findOrFail($id);

      $ministre->update($request->except('photo'));

      if($request->has('photo')) {
        $fichier = $this->storeImageFile($request->photo, 'pays/' . $request->pays . '/ministre');

        $ministre->update(['photo' => $fichier->id]);
      }


      return $ministre->refresh();
    }


    public function getByPays( Request $request, $pays){
      $ministres = $this->filterByPays($this->modelQuery, [$pays]);

      return $this->refineData($ministres, $request)->latest()->get();
    }
}
