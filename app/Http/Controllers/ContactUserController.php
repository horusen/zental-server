<?php

namespace App\Http\Controllers;

use App\Models\ContactUser;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class ContactUserController extends BaseController
{
    protected $model = ContactUser::class;
    protected $validation = [
        'type_contact' => 'required|integer|exists:zen_type_contact,id',
        'user' => 'required|integer|exist:cpt_inscription,id_inscription',
        'contact' => 'required|integer|exist:cpt_inscription,id_inscription'
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }
}
