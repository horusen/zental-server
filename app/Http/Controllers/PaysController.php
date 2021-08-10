<?php

namespace App\Http\Controllers;

use App\Models\Pays;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class PaysController extends BaseController
{
    protected $model = Pays::class;
    protected $validation = [
        'libelle' => 'required'
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }

    public function getAll()
    {
        return $this->model::all();
    }
}
