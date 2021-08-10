<?php

namespace App\Http\Controllers;

use App\Models\ArtsEtCulture;
use App\Models\IciChezNous;
use App\Models\MotDuPresident;
use App\Models\venirChezNous;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IciMonPaysController extends BaseController
{
    protected $model = IciChezNous::class;
    protected $validation = [
        'description' => 'required',
        'pays' => 'required|integer|exists:pays,id',
        'element' => 'required|string' // Peut prendre les valeurs -> iciChezNous, VenirChezNous, MotDuPresident
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }

    // public function store(Request $request)
    // {
    //     $validated = $this->validate($request, $this->validation);
    //     return $this->save($validated);
    // }

    public function save(array $validatedRequest)
    {
        if ($validatedRequest['element'] == 'ici-chez-nous') {
            return IciChezNous::create(array_merge($validatedRequest, ['inscription' => Auth::id()]));
        } else if ($validatedRequest['element'] == 'venir-chez-nous') {
            return venirChezNous::create(array_merge($validatedRequest, ['inscription' => Auth::id()]));
        } else if ($validatedRequest['element'] == 'arts-et-cultures') {
            return ArtsEtCulture::create(array_merge($validatedRequest, ['inscription' => Auth::id()]));
        } else if ($validatedRequest['element'] == 'mot-du-president') {
            return MotDuPresident::create(array_merge($validatedRequest, ['inscription' => Auth::id()]));
        }
    }

    public function showElement($pays, $element)
    {
        if ($element == 'ici-chez-nous') {
            return IciChezNous::where('pays', $pays)->first();
        } else if ($element == 'venir-chez-nous') {
            return venirChezNous::where('pays', $pays)->first();
        } else if ($element == 'arts-et-cultures') {
            return ArtsEtCulture::where('pays', $pays)->first();
        } else if ($element == 'mot-du-president') {
            return MotDuPresident::where('pays', $pays)->first();
        }

        return response()->json([], 404);
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, $this->validation);

        $element = null;
        if ($validated['element'] == 'ici-chez-nous') {
            $element = IciChezNous::where('pays', $validated['pays'])->first();
        } else  if ($validated['element'] == 'venir-chez-nous') {
            $element = venirChezNous::where('pays', $validated['pays'])->first();
        } else  if ($validated['element'] == 'mot-du-president') {
            $element = MotDuPresident::where('pays', $validated['pays'])->first();
        } else  if ($validated['element'] == 'arts-et-cultures') {
            $element = ArtsEtCulture::where('pays', $validated['pays'])->first();
        }

        if (isset($element)) {
            $element->delete();
        }

        return $this->save($validated);
    }
}
