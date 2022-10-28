<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ConfirmationInscriptionMail;
use App\Models\Addresse;
use App\Models\Nationalite;
use App\Traits\FileHandlerTrait;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Shared\Models\MyHelper;

class AuthController extends Controller
{
    use  FileHandlerTrait;

    public function login(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Erreur de connexion'], 401);
        }

        $token = Auth::user()->createToken('authToken');

        return response()->json([
            'access_token' => $token->accessToken,
            // 'refresh_token' => $token->refresh_token,
            'user' => Auth::user(),
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->token->expires_at)->toDateTimeString()
        ]);
    }


    public function signup(Request $request)
    {
        // Request validation
        $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'date_naissance' => 'required|string|date',
            'lieu_naissance' => 'required|integer|exists:ville,id_ville',
            'photo' => 'image|nullable',
            'photo_min' => 'image|nullable',
            'email' => 'required|string|email|unique:cpt_inscription,email|max:255',
            'password' => 'required|string|min:6|max:255|confirmed',
            'nationalites' => 'required',
            'addresse' => 'required|string',
            'ville' => 'required|integer|exists:ville,id_ville',
            'sexe' => 'required|string|in:homme,femme',
            'telephone' => 'required|string',
            'profession' => 'required|string',
            'condition_utilisation' => 'required|accepted'
        ]);


        // User creation
        $user = User::create($request->merge(['password' => Hash::make($request->password)])
            ->except(['ville', 'addresse', 'photo', 'photo_min']));

        // User email confirmation
        $user->sendEmailVerificationNotification();


        // Add Addresse
        $adresse = Adresse::create([
            'adresse' => $request['addresse'],
            'ville' => $request['ville'],
            'inscription' => $user->id_inscription
        ]);

        $user->update(['addresse' => $adresse->id]);


        // Add Profile pic
        if ($request->has('photo')) {
            $photo = $this->storeFile($request->photo, 'inscription/' . $user->id . '/photo');
            $photo_min = $this->storeFile($request->photo_min, 'inscription/' . $user->id . '/photo-min');
            $user->update([
                'photo' =>  $photo->id,
                'photo_min' =>  $photo_min->id
            ]);
        }





        // Add Nationalite
        foreach (explode(',', $request->nationalites) as $nationalite) {
            Nationalite::create([
                'user' => $user->id_inscription,
                'pays' => $nationalite,
                'inscription' => $user->id_inscription
            ]);
        }

        Auth::login($user);

        $token = Auth::user()->createToken('authToken');

        return response()->json([
            'access_token' => $token->accessToken,
            'user' => User::with('nationalites.pays')->find(Auth::id()),
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->token->expires_at)->toDateTimeString()
        ]);
    }

    public function addUser(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'prenom' => 'required',
            'nom' => 'required',
            'email' => 'sometimes|string|email|unique:cpt_inscription,email|max:255',
            'addresse' => 'sometimes',
            'ville' => 'required_with:addresse|nullable|integer|exists:ville,id_ville'

        ]);

        $user = User::create([
            'email' => $request->email,
            'prenom' => $request->prenom,
            'nom' => $request->nom,
            'telephone' => $request->telephone,
            'profession' => $request->profession,
            'date_naissance' => $request->date_naissance,
            'lieu_naissance' => $request->lieu_naissance,
            'sexe' => $request->sexe,
        ]);

        if ($request->has('addresse')) {
            $addresse = Addresse::create([
                'addresse' => $request['addresse'],
                'ville' => $request['ville'],
                'inscription' => Auth::id()
            ]);

            $user->update(['addresse' => $addresse->id]);
        }

        if (isset($user->email)) {
            Mail::to($user->email)->send(new ConfirmationInscriptionMail(Auth::user(), $user));
        }

        return $user;
    }

    public function verifyConfirmationToken(User $user, Request $request)
    {
        if (Hash::check($user->email, $request->token)) {
            return $user;
        }


        return response()->json(['error' => 'Invalid token']);
    }

    public function edit(Request $request)
    {
        $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'date_naissance' => 'required|string|date',
            'photo' => 'image',
            'photo_min' => 'image',
            'sexe' => 'required',
            'email' => 'required|string|email|max:255',
            'nationalites' => 'required',
        ]);

        $user = User::find(Auth::id());
        $user->update($request->all());


        // Nationalités
        $nationalites = explode(',', $request->nationalites);


        foreach ($user->nationalites as $nationalite) {
            if (!in_array($nationalite->pays, $nationalites)) {
                $nationalite->delete();
            }
        }

        foreach ($nationalites as $nationalite) {
            if (!in_array($nationalite, MyHelper::idExtractor($user->nationalites, 'pays'))) {
                Nationalite::create([
                    'user' => Auth::id(),
                    'pays' => $nationalite,
                    'inscription' => Auth::id()
                ]);
            }
        }

        if ($request->has('photo')) {
            $photo = $this->storeFile($request->photo, 'inscription/' . $request->email . '/photo');
            $photo_min = $this->storeFile($request->photo_min, 'inscription/' . $request->email . '/photo-min');
            $user->update([
                'photo' => is_null($photo) ? NULL : $photo->id,
                'photo_min' => is_null($photo_min) ? NULL : $photo_min->id
            ]);
        }

        return User::with('nationalites.pays')->find(Auth::id());
    }


    public function getUser()
    {
        return response()->json(['user' => User::find(Auth::id())]);
    }

    // public function resendEmailVerification(User $user)
    // {
    //     $user = $user->resendEmailVerification();
    // }


    public function update(User $user, Request $request)
    {
        $validations = Validator::make($request->all(), [
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'date_naissance' => 'required|string|date',
            'photo' => 'image',
            'photo_min' => 'image',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|max:255|confirmed',
            'nationalites' => 'required'
        ]);

        if ($validations->fails()) {
            return response()->json($validations->messages(), 422);
        }

        $user->update($request->all());

        return $user->refresh();
    }


    public function logout()
    {
        Auth::user()->token()->revoke();
        return null;
    }
}
