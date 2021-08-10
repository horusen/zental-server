<?php

namespace App\Http\Controllers;

use App\Models\AffectationEmployeService;
use App\Models\Employe;
use App\Shared\Controllers\BaseController;
use App\Traits\FileHandlerTrait;
use App\Traits\MembreCabinetMinistreTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembreCabinetMinistreController extends BaseController
{
    use MembreCabinetMinistreTrait, FileHandlerTrait;
    protected $model = Employe::class;
    protected $validation = [
        'membre' => 'required|integer|exists:cpt_inscription,id_inscription',
        'poste' => 'required|integer|exists:zen_poste,id',
        'debut' => 'required|date',
        'fonction' => 'required|integer|exists:zen_fonction,id',
        'service' => 'required|integer|exists:zen_service,id',
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }

    public function getByMinistre(Request $request, $ministre)
    {
        $membres = $this->filterByMinistres($this->modelQuery, [$ministre]);
        return $this->refineData($membres, $request)->latest()->get();
    }

    public function getNonMembresCabinet($ministre)
    {
        return $this->filterNonMembresCabinet($this->modelQuery, [$ministre])->latest()->get();
    }


    public function store(Request $request)
    {
        $validated = $this->validate($request, $this->validation);
        $employe = $this->model::create([
            'employe' => $validated['membre'],
            'debut' => $validated['debut'],
            'note' => $validated['note'],
            'poste' => $validated['poste'],
            'fonction' => $validated['fonction'],
            'inscription' => Auth::id()
        ]);

        AffectationEmployeService::create([
            'employe' => $employe->id,
            'service' => $validated['service'],
            'inscription' => Auth::id()
        ]);


        if ($request->has('fichier_joint')) {
            $fichier_joint = $this->storeFile($request->fichier_joint, 'employe/' . $request->employe . '/fichier_joint');
            $employe->update([
                'fichier_joint' =>  $fichier_joint->id,
            ]);
        }


        return $this->model::find($employe->id);
    }
}
