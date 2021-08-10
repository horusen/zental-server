<?php

namespace App\Http\Controllers;

use App\Models\Ville;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class VilleController extends BaseController
{
    protected $model = Ville::class;
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



    public function getByPays($pays)
    {
        return $this->model::where('pays', $pays)->get();
    }
}
