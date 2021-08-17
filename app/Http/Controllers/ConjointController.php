<?php

namespace App\Http\Controllers;

use App\Models\Conjoint;
use App\Shared\Controllers\BaseController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConjointController extends BaseController
{
    protected $model = Conjoint::class;
    protected $validation = [
        'meme_pays' => 'required_if:situation_matrimoniale,5|bool',
        'meme_nationalite' => 'required_if:situation_matrimoniale,5|bool',
        'vivre_ensemble' => 'required_if:situation_matrimoniale,5|bool',
        'conjoint1' => 'required|integer|exists:cpt_inscription,id_inscription',
        'conjoint2' => 'required_if:situation_matrimoniale,5|integer|exists:cpt_inscription,id_inscription'
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }


    public function getByUser($user)
    {
        return $this->model::where('conjoint1', $user)->orWhere('conjoint2', $user)->first();
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->validation);

        // Update user situation matrimoniale
        User::find($request->conjoint1)->update(['situation_matrimoniale' => $request->situation_matrimoniale]);


        // If situation matrimoniale is "marié" create a conjoint record and return it
        if ($request->situation_matrimoniale === 2) {
            $conjoint = $this->model::create(array_merge($request->all(), ['inscription' => Auth::id()]));
            return $this->model::find($conjoint->id);
        }


        // Otherwise return null
        return null;
    }


    public function destroy($id)
    {
        // Suppression du conjoint
        $conjoint = $this->model::findOrFail($id);
        $conjoint->delete();


        // Mise à jour du champs situation_matrimoniale dans User
        $users = User::whereIn('id_inscription', [$conjoint->conjoint1, $conjoint->conjoint2])->get();
        foreach ($users as $user) {
            $user->update(['situation_matrimoniale' => 5]);
        }


        return null;
    }
}
