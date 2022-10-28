<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class ChargerComController extends BaseController
{
    // Don't forget to extends BaseController
    protected $model = Employe::class;
    protected $validation = [
        'charger_com' => 'boolean'
    ];


    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }


    public function getByService($service)
    {
        return $this->model::whereHas('services', function ($q) use ($service) {
            $q->where('zen_service.id', $service);
        })->where('charger_com', 1)->latest()->get();
    }

    public function update(Request $request, $id)
    {
        $request->validate(['charger_com' => 'required|boolean']);

        $employe = $this->model::find($id);
        $employe->update(['charger_com' => $request->charger_com]);
        return $employe;
    }
}
