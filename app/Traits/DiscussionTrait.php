<?php

namespace App\Traits;

use App\Models\CorrespondanceGroupe;
use App\Models\CorrespondanceService;
use App\Models\CorrespondanceUtilisateur;
use App\Models\CorrespondanceUtilisateurService;
use App\Models\Discussion;
use App\Models\MembreGroupe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


trait DiscussionTrait
{
    private function checkCorrepondanceUtilisateur(int $user, int $user2)
    {
        return Discussion::whereHas('correspondance_utilisateur', function ($q) use ($user, $user2) {
            $q->where([
                ['user1', '=', $user],
                ['user2', '=', $user2]
            ])->orWhere([
                ['user1', '=', $user2],
                ['user2', '=', $user]
            ]);
        })->first();
    }

    private function checkCorrepondanceUtilisateurService(int $user, int $service)
    {
        return Discussion::whereHas('correspondance_utilisateur_service', function ($q) use ($user, $service) {
            $q->where('user', $user)->where('service', $service);
        })->first();
    }


    private function checkCorrepondanceGroupe(int $user, int $groupe)
    {
        $membre = MembreGroupe::where('membre', $user)->where('groupe', $groupe)->first();
        if (isset($membre)) {
            return Discussion::whereHas('correspondance_groupe', function ($q) use ($groupe) {
                $q->where('groupe', $groupe);
            })->first();
        }

        return response()->json(['erreur' => "Le user n'est pas membre du groupe"], 401);
    }


    private function checkCorrepondanceService(int $service, int $service1)
    {
        return Discussion::whereHas('correspondance_service', function ($q) use ($service, $service1) {
            $q->where([
                ['service1', '=', $service],
                ['service2', '=', $service1]
            ])->orWhere([
                ['service1', '=', $service1],
                ['service2', '=', $service]
            ]);
        })->first();
    }


    private function create(Request $request)
    {
        $discussion = Discussion::create([
            'type' => $request->type_discussion,
            'inscription' => Auth::id(),
        ]);

        switch ($request->type_discussion) {
            case 1:
                CorrespondanceUtilisateur::create([
                    'user1' => $request->user,
                    'user2' => $request->user2,
                    'discussion' => $discussion->id,
                    "inscription" => Auth::id()
                ]);
                break;
            case 2:
                CorrespondanceUtilisateurService::create([
                    'user' => $request->user,
                    'service' => $request->service,
                    'discussion' => $discussion->id,
                    "inscription" => Auth::id()
                ]);
                break;
            case 3:
                CorrespondanceGroupe::create([
                    'groupe' => $request->groupe,
                    'discussion' => $discussion->id,
                    "inscription" => Auth::id()
                ]);
                break;
            case 4:
                CorrespondanceService::create([
                    'service1' => $request->service,
                    'service2' => $request->service2,
                    'discussion' => $discussion->id,
                    "inscription" => Auth::id()
                ]);
                break;
        }

        return $discussion;
    }
}
