<?php

namespace App\Http\Controllers;

use App\Models\ContactUser;
use App\Shared\Controllers\BaseController;
use App\Traits\ContactUserTrait;
use Illuminate\Http\Request;

class ContactUserController extends BaseController
{
    use ContactUserTrait;
    protected $model = ContactUser::class;
    protected $validation = [
        'type_contact' => 'required|integer|exists:zen_type_contact,id',
        'user' => 'required|integer|exists:cpt_inscription,id_inscription',
        'contact' => 'required|integer|exists:cpt_inscription,id_inscription'
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }



    public function getByUser(Request $request, $user)
    {
        $relations = $this->filterByUser($this->modelQuery, $user);
        return $this->refineData($relations, $request)->latest()->get();
    }

    public function getContactUrgentByUser($user)
    {
        return $this->model::where('user', $user)->where('urgence', true)->get();
    }
}
