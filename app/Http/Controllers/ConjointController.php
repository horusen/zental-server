<?php

namespace App\Http\Controllers;

use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class ConjointController extends BaseController
{
    protected $model = Famille::class;
    protected $validation = [
        'meme_pays' => 'required|bool',
        'meme_nationalite' => 'required|bool',
        'conjoint1' => 'required|integer|exist:cpt_inscription,id_inscription',
        'conjoint2' => 'required|integer|exist:cpt_inscription,id_inscription'
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }
}
