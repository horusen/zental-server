<?php

namespace App\Traits;

use App\Models\Eleve;
use App\Models\Professeur;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;

trait AuthenticationTrait
{
    protected function validationInscription(Request $request)
    {
        $this->validate($request, [
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'date_naissance' => 'required|string|date',
            'photo' => 'image',
            'photo_min' => 'image',
            'email' => 'required|string|email|unique:cpt_inscription,email|max:255',
            'password' => 'required|string|min:6|max:255|confirmed'
        ]);
    }


    protected function validationConnexion(Request $request)
    {
        return $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
    }


    public function getPersonalAccessToken()
    {
        if (request()->remember_me === 'true')
            Passport::personalAccessTokensExpireIn(now()->addDays(15));

        return Auth::user()->createToken('Personal Access Token');
    }

    protected function token($personalAccessToken, $message = null, $code = 200)
    {
        $profiles = $this->getProfiles();
        $tokenData = [
            'profiles' => $profiles->profiles,
            'profilesCount' => $profiles->profilesCount,
            'access_token' => $personalAccessToken->accessToken,
            'user' => Auth::user(),
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($personalAccessToken->token->expires_at)->toDateTimeString()
        ];

        return $tokenData;
    }

    protected function success($data, $message = null, $code = 200)
    {
        return response()->json([
            'status' => 'Success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function error($message = null, $code)
    {
        return response()->json([
            'status' => 'Error',
            'message' => $message,
            'data' => null
        ], $code);
    }

    protected function getProfiles()
    {
        $profiles = [];
        $profilesEleves = $this->getEleveProfiles();
        $profilesProfesseurs = $this->getProfesseurProfiles();

        foreach ($profilesEleves as $profile) {
            array_push($profiles, [
                'type' => 'eleve',
                'profil' => $profile
            ]);
        }

        foreach ($profilesProfesseurs as $profile) {
            array_push($profiles, [
                'type' => 'professeur',
                'profil' => $profile
            ]);
        }





        return (object) [
            'profiles' => $profiles,
            'profilesCount' => count($profiles)
        ];
    }


    protected function getEleveProfiles()

    {
        return Eleve::where('eleve', Auth::id())->get()->each->append('etablissement_details');
    }

    protected function getProfesseurProfiles()
    {
        return Professeur::where('professeur', Auth::id())->get()->each->append('etablissement_details');
    }
}
