<?php

namespace App\Http\Controllers;

use App\Models\EvenementCalendrierPays;
use App\Shared\Controllers\BaseController;
use App\Traits\EvenementCalendrierPaysTrait;
use Illuminate\Http\Request;

class EvenementCalendrierPaysController extends BaseController
{
    use EvenementCalendrierPaysTrait;
    protected $model = EvenementCalendrierPays::class;
    protected $validation = [
        'libelle' => 'required',
        'date' => 'required|date'
    ];


    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }


    public function getByPays(Request $request, $pays){
      $evenements = $this->filterByPays($this->modelQuery, [$pays]);
      return $this->refineData($evenements, $request)->orderBy('date')->get();
    }
}
