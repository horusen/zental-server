<?php

namespace App\Http\Controllers;

use App\PieceConsulaire;
use App\Shared\Controllers\BaseController;
use App\Traits\FileHandlerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PieceConsulaireController extends BaseController
{
    use FileHandlerTrait;
    protected $model = PieceConsulaire::class;
    protected $validation = [
        'fichier_joint' => 'required|file',
        'type' => 'required|integer|exists:zen_type_piece_consulaire,id',
        'user' => 'required|integer|exists:cpt_inscription,id_inscription',
        'debut' => 'required|date|before:fin',
        'fin' => 'required|date|after:debut'
    ];


    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }


    public function store(Request $request)
    {
        $this->validate($request, $this->validation);

        $fichier_joint = $this->storeFile($request->fichier_joint, 'user/' . $request->user . '\/piece-consulaire/' . $request->type . '/fichier_joint');
        $piece_consulaire = $this->model::create([
            'type' => $request->type,
            'user' => $request->user,
            'debut' => $request->debut,
            'fin' => $request->fin,
            'fichier_joint' => $fichier_joint->id,
            'inscription' => Auth::id(),
        ]);

        return $this->model::find($piece_consulaire->id);
    }


    public function update(Request $request, $id)
    {
        return $request->all();
        $this->validate($request, [
            'debut' => 'required|date|before:fin',
            'fin' => 'required|date|after:debut'
        ]);

        $piece = $this->model::find($id);
        $piece->update($request->all());
        return $this->model::find($piece->id);
    }


    public function getByUserAndType($user, $type)
    {
        return $this->model::where('type', $type)->where('user', $user)->first();
    }
}
