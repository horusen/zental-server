<?php

namespace App\Http\Controllers;

use App\Models\President;
use App\Shared\Controllers\BaseController;
use App\Traits\FileHandlerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresidentController extends BaseController
{
    use FileHandlerTrait;

    // Don't forget to extends BaseController
    protected $model = President::class;
    protected $validation = [
        'nom' => 'required',
        'prenom' => 'required',
        'biographie' => 'required',
        'photo' => 'file',
        'pays'=> 'required|integer|exists:pays,id'
    ];


    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }

    public function store(Request $request) {
        $request->validate($this->validation);

        $president = President::create($request->except('photo') + ['inscription' => Auth::id()]);

        $fichier = $this->storeImageFile($request->photo, 'pays/' . $request->pays . '/president');

        $president->update(['photo' => $fichier->id]);

        return $this->model::find($president->id);

    }


    public function update(Request $request, $id){

      $request->validate($this->validation);

      $president = $this->model::findOrFail($id);

      $president->update($request->except('photo'));

      if($request->has('photo')) {
        $fichier = $this->storeImageFile($request->photo, 'pays/' . $request->pays . '/president');

        $president->update(['photo' => $fichier->id]);
      }


      return $president->refresh();
    }


    public function getByPays($pays){
      return $this->model::where('pays', $pays)->latest()->first();
    }
}
