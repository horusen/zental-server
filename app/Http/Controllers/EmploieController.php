<?php

namespace App\Http\Controllers;

use App\Models\Emploie;
use App\Shared\Controllers\BaseController;
use App\Traits\FileHandlerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmploieController extends BaseController
{
    use FileHandlerTrait;
    protected $model = Emploie::class;
    protected $validation = [
        'domaine' => 'required|integer|exists:exp_domaine,id',
        'type_contrat' => 'required|integer|exists:zen_type_contrat,id',
        'user' => 'required|integer|exists:cpt_inscription,id_inscription',
        'debut' => 'date',
        'fin' => 'nullable|date',
        'etablissement' => 'required'
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }


    public function getByUser($user)
    {
        return $this->model::where('user', $user)->latest()->get();
    }


    public function store(Request $request)
    {
        $this->validate($request, $this->validation);
        $emploie = $this->model::create(array_merge($request->all(), ['inscription' => Auth::id()]));

        if ($request->has('fichier_joint')) {
            $fichier_joint = $this->storeFile($request->fichier_joint, 'emploie/' . Auth::user()->email . '/fichier_joint');
            $emploie->fichier_joint = $fichier_joint->id;
            $emploie->save();
        }



        return $this->model::find($emploie->id);
    }
}
