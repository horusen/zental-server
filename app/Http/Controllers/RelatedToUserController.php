<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class RelatedToUserController extends Controller
{
    public function getNonMembresGroupe($groupe)
    {
        return User::whereDoesntHave('membership_groupe', function ($q) use ($groupe) {
            $q->where('groupe', $groupe);
        })->get();
    }
}
