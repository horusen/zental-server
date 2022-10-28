<?php

namespace App\Http\Controllers;


use App\Models\Discussion;
use App\Traits\DiscussionTrait;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    use DiscussionTrait;
    public function getDiscussion(Request $request)
    {
        $request->validate([
            'type_discussion' => 'required|integer|exists:zen_type_discussion,id',
            'user' => 'required_if:type_discussion,1,2,3|integer|exists:cpt_inscription,id_inscription',
            'user2' => 'required_if:type_discussion,1|integer|exists:cpt_inscription,id_inscription',
            'service' => 'required_if:type_discussion,2,4|integer|exists:zen_service,id',
            'service2' => 'required_if:type_discussion,4|integer|exists:zen_service,id',
            //   'groupe' => 'required_if:type_discussion,3|integer|exists:zen_groupe'
        ]);

        $discussion = null;

        switch ($request->type_discussion) {
            case 1:
                $discussion = $this->checkCorrepondanceUtilisateur($request->user, $request->user2);
                break;
            case 2:
                $discussion = $this->checkCorrepondanceUtilisateurService($request->user, $request->service);
                break;
            case 3:
                $discussion = $this->checkCorrepondanceGroupe($request->user, $request->groupe);
                break;
            case 4:
                $discussion = $this->checkCorrepondanceService($request->service, $request->service2);
                break;

            default:
                return response()->json([], 422);
                break;
        }

        if (!isset($discussion)) {
            $discussion = $this->create($request);
        }


        return Discussion::find($discussion->id);
    }


    public function show(Discussion $discussion)
    {
        return $discussion;
    }


    // Reordonner les discussions au niveaux de la dernieres lignes
    public function getDernieresDiscussions($type, $id)
    {
        if ($type == 'users') {
            return Discussion::whereHas('correspondance_utilisateur', function ($q) use ($id) {
                $q->where('user1', $id)->orWhere('user2', $id);
            })
                ->orWhereHas('correspondance_utilisateur_service', function ($q) use ($id) {
                    $q->where('user', $id);
                })
                ->orWhereHas('correspondance_groupe.groupe.membres', function ($q) use ($id) {
                    $q->where('membre', $id);
                })
                ->has('reactions')
                ->orderBy('touched_at', 'desc')
                ->get();
        } else if ($type == 'services') {
            return Discussion::whereHas('correspondance_service', function ($q) use ($id) {
                $q->where('service1', $id)->orWhere('service2', $id);
            })
                ->orWhereHas('correspondance_utilisateur_service', function ($q) use ($id) {
                    $q->where('service', $id);
                })->has('reactions')
                ->orderBy('touched_at', 'desc')
                ->get();
        }

        return response()->json([], 404);
    }
}
