<?php

namespace App\Http\Controllers;

use App\Models\Diplome;
use App\Shared\Controllers\BaseController;
use App\Traits\FileHandlerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiplomeController extends BaseController
{
    protected $model = Diplome::class;
    use  FileHandlerTrait;
    protected $validation = [
        'domaine' => 'required|integer|exists:exp_domaine,id',
        'niveau' => 'required|integer|exists:zen_niveau,id',
        'user' => 'required|integer|exists:cpt_inscription,id_inscription',
        'annee_obtention' => 'required|date_format:"Y"',
        'etablissement' => 'required'
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }


    public function store(Request $request)
    {
        $this->validate($request, $this->validation);
        $diplome = $this->model::create(array_merge($request->all(), ['inscription' => Auth::id()]));

        if ($request->has('fichier_joint')) {
            $fichier_joint = $this->storeFile($request->fichier_joint, 'diplome/' . Auth::user()->email . '/fichier_joint');
            $diplome->fichier_joint = $fichier_joint->id;
            $diplome->save();
        }



        return $this->model::find($diplome->id);
    }


    public function getByUser($user)
    {
        return $this->model::where('user', $user)->orderBy('annee_obtention')->get();
    }
}
