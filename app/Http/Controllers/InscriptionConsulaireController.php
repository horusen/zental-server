<?php

namespace App\Http\Controllers;

use App\Models\AffectationInscriptionConsulaireAmbassade;
use App\Models\AffectationInscriptionConsulaireConsulat;
use App\Models\AffectationInscriptionConsulaireLiaison;
use App\Models\InscriptionConsulaire;
use App\Models\MotifRefusInscriptionConsulaire;
use App\PieceConsulaire;
use App\Shared\Controllers\BaseController;
use App\Traits\FileHandlerTrait;
use App\Traits\InscriptionConsulaireTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InscriptionConsulaireController extends BaseController
{
    use FileHandlerTrait, InscriptionConsulaireTrait;
    // Don't forget to extends BaseController
    protected $model = InscriptionConsulaire::class;
    protected $validation = [
        'user' => 'required|integer|exists:cpt_inscription,id_inscription',
        'justificatif_residence' => 'required|file',
        'ambassade' => "required_without_all:consulat,liaison|integer|exists:zen_ambassade,id",
        'consulat' => "required_without_all:ambassade,liaison|integer|exists:zen_consulat,id",
        'liaison' => "required_without_all:ambassade,consulat|integer|exists:zen_liaison,id",
    ];


    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }


    public function getByAmbassade(Request $request, $ambassade)
    {
        $inscriptionConsulaires = $this->filterByAmbassades($this->modelQuery, [$ambassade]);
        return $this->refineData($inscriptionConsulaires, $request)->with('user', 'justificatif_residence')->get();
    }


    public function getByConsulat(Request $request, $consulat)
    {
        $inscriptionConsulaires = $this->filterByConsulats($this->modelQuery, [$consulat]);
        return $this->refineData($inscriptionConsulaires, $request)->with('user', 'justificatif_residence')->get();
    }

    public function getByLiaison(Request $request, $liaison)
    {
        $inscriptionConsulaires = $this->filterByLiaisons($this->modelQuery, [$liaison]);
        return $this->refineData($inscriptionConsulaires, $request)->with('user', 'justificatif_residence')->get();
    }


    public function getByPays(Request $request, $pays)
    {
        $inscriptionConsulaires = $this->filterByPays($this->modelQuery, [$pays]);
        return $this->refineData($inscriptionConsulaires, $request)->with('user', 'justificatif_residence')->get();
    }



    public function store(Request $request)
    {
        $this->validate($request, $this->validation);

        if ($this->_checkInscriptionValide($request->user)) {
            return $this->responseError("Vous êtes déjà inscrit dans un consulat", 401);
        } else if ($this->_checkInscriptionEnCours($request->user)) {
            return $this->responseError("Vous êtes déjà inscription consulaire en cours", 401);
        } else if (!$this->_checkPasseport($request->user)) {
            return $this->responseError("Vous n'avez pas encore ajouter votre passeport", 401);
        }

        $justificatif_residence = $this->storeDocumentFile($request->justificatif_residence, 'inscription-consulaire/' . $request->user . '/justificatif_residence');

        $type_entite_diplomatique = null;

        if ($request->has('ambassade')) {
            $type_entite_diplomatique = 1;
        } else if ($request->has('consulat')) {
            $type_entite_diplomatique = 2;
        } else if ($request->has('liaison')) {
            $type_entite_diplomatique = 3;
        }

        $inscriptionConsulaire = $this->model::create(
            $request->except(['justificatif_residence']) + [
                'inscription' => Auth::id(),
                'type_entite_diplomatique' => $type_entite_diplomatique,
                'justificatif_residence' => $justificatif_residence->id,
            ]
        );


        if ($request->has('ambassade')) {
            AffectationInscriptionConsulaireAmbassade::create([
                'ambassade' => $request->ambassade,
                'inscription_consulaire' => $inscriptionConsulaire->id,
                'inscription' => Auth::id()
            ]);
        } else if ($request->has('consulat')) {
            AffectationInscriptionConsulaireConsulat::create([
                'consulat' => $request->consulat,
                'inscription_consulaire' => $inscriptionConsulaire->id,
                'inscription' => Auth::id()
            ]);
        } else if ($request->has('liaison')) {
            AffectationInscriptionConsulaireLiaison::create([
                'liaison' => $request->liaison,
                'inscription_consulaire' => $inscriptionConsulaire->id,
                'inscription' => Auth::id()
            ]);
        }


        return $this->model::with(['user', 'justificatif_residence'])->find($inscriptionConsulaire->id);
    }


    public function changerEtat(Request $request)
    {
        $request->validate([
            'inscription_consulaire' => 'required_without:user|nullable|integer|exists:zen_inscription_consulaire,id',
            'user' => 'required_without:inscription_consulaire|nullable|integer|exists:cpt_inscription,id_inscription',
            'etat' => 'required|integer|exists:zen_etat_inscription_consulaire,id',
            'motif' => 'required_if:etat,3,5`'
        ]);

        if ($request->has('inscription_consulaire')) {
            $inscription_consulaire = $this->model::find($request->inscription_consulaire);
        } else if ($request->has('user')) {
            $inscription_consulaire = $this->model::where('user', $request->user)->latest()->first();
        }


        $inscription_consulaire->update(['etat' => $request->etat]);

        if ($request->etat == 3) {
            MotifRefusInscriptionConsulaire::create([
                'inscription_consulaire' => $inscription_consulaire->id,
                'description' => $request->motif,
                'inscription' => Auth::id()
            ]);
        }

        return $inscription_consulaire->refresh();
    }

    public function checkEligibility($user)
    {
        if ($this->_checkInscriptionValide($user)) {
            return $this->responseError("Vous êtes déjà inscrit dans un consulat", 401);
        } else if ($this->_checkInscriptionEnCours($user)) {
            return $this->responseError("Vous avez déjà une inscription consulaire en cours", 401);
        } else if (!$this->_checkPasseport($user)) {
            return $this->responseError("Vous n'avez pas encore ajouter votre passeport", 401);
        }

        return;
    }


    // Check if the user has already a valid inscription_consulaire
    private function _checkInscriptionValide(int $user): bool
    {
        $inscription = $this->model::where('user', $user)->where('etat', 2)->first();
        return isset($inscription);
    }


    // Check if the user has already a processing inscription_consulaire
    private function _checkInscriptionEnCours(int $user): bool
    {
        $inscription = $this->model::where('user', $user)->where('etat', 1)->first();
        return isset($inscription);
    }

    // Check if the user has a passeport
    private function _checkPasseport(int $user): bool
    {
        $passeport = PieceConsulaire::where('user', $user)->where('type', 1)->first();
        return isset($passeport);
    }
}
