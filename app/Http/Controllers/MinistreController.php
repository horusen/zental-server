<?php

namespace App\Http\Controllers;

use App\Models\Ministre;
use App\Shared\Controllers\BaseController;
use App\Traits\MinistreTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MinistreController extends BaseController
{
    use MinistreTrait;
    protected $model = Ministre::class;
    protected $validation = [
        'ministre' => 'required|integer|exists:cpt_inscription,id_inscription',
        'ministere' => 'required|integer|exists:zen_ministere,id',
        'debut_fonction' => 'required|date',
        'fin_fonction' => 'nullable|date',
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }

    public function getActuelMinistre($ministere)
    {
        return $this->model::where('ministere', $ministere)->where('en_fonction', true)->with('ministre.photo')->first();
    }

    public function getByMinistere(Request $request, $ministere)
    {
        $ministres = $this->filterByMinisteres($this->modelQuery, [$ministere])->where('en_fonction', false);
        return $this->refineData($ministres, $request)->latest()->get();
    }

    public function store(Request $request)
    {
        $this->isValid($request);
        if ($request->en_fonction === true) {
            $this->_setEnFonctionFieldFromAllTablesToFalse($request->ministere);
        }

        $item = $this->model::create(array_merge($request->all(), ['inscription' => Auth::id()]));
        return $this->model::find($item->id);
    }

    public function show($id)
    {
        return $this->model::with('ministre.photo')->findOrFail($id);
    }

    private function _setEnFonctionFieldFromAllTablesToFalse($ministere)
    {
        $this->model::where('ministere', $ministere)->update(['en_fonction' => false]);
    }
}
