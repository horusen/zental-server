<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ConfirmationInscriptionMail;
use App\Models\Nationalite;
use App\Traits\FileHandlerTrait;
use App\User;
use Carbon\Carbon;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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
            'user' => Auth::user(),
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->token->expires_at)->toDateTimeString()
        ]);
    }


    public function signup(Request $request)
    {

        $validations = Validator::make($request->all(), [
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'date_naissance' => 'required|string|date',
            'photo' => 'image',
            'photo_min' => 'image',
            'email' => 'required|string|email|unique:cpt_inscription,email|max:255',
            'password' => 'required|string|min:6|max:255|confirmed',
            'nationalites' => 'required'
        ]);

        if ($validations->fails()) {
            return response()->json($validations->messages(), 422);
        }


        $user = User::create([
            'prenom' => $request->prenom,
            'date_naissance' => $request->date_naissance,
            'nom' => $request->nom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ])->sendEmailVerificationNotification();

        if ($request->has('photo')) {
            $photo = $this->storeFile($request->photo, 'inscription/' . $request->email . '/photo');
            $photo_min = $this->storeFile($request->photo_min, 'inscription/' . $request->email . '/photo-min');
            $user->update([
                'photo' => is_null($photo) ? NULL : $photo->id,
                'photo_min' => is_null($photo_min) ? NULL : $photo_min->id
            ]);
        }


        foreach ($request->nationalites as $nationalite) {
            Nationalite::create([
                'user' => $user->id_inscription,
                'pays' => $nationalite,
                'inscription' => $user->id_inscription
            ]);
        }

        return $user;
    }

    public function addUser(Request $request)
    {
        $this->validate($request, [
            'prenom' => 'required',
            'nom' => 'required',
            'email' => 'required|string|email|unique:cpt_inscription,email|max:255',
        ]);

        $user = User::create(['email' => $request->email, 'prenom' => $request->prenom, 'nom' => $request->nom]);

        Mail::to($user->email)->send(new ConfirmationInscriptionMail(Auth::user(), $user));

        return $user;
    }

    public function verifyConfirmationToken(User $user, Request $request)
    {
        if (Hash::check($user->email, $request->token)) {
            return $user;
        }


        return response()->json(['error' => 'Invalid token']);
    }


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
}
