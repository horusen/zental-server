<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait BaseTrait
{
    public function filter($elementss, $filteringParams)
    {
        return $elementss;
    }


    public function search($elements, $keyword)
    {
        return $elements->where('libelle', 'like', '%' . $keyword . '%');
    }


    public function applyFilter($elements, Request $request)
    {
        if ($request->has('filter')) {
            $elements = $this->filter($elements, json_decode($request->filter, true));
        }

        return $elements;
    }

    public function applySearch($elements, Request $request)
    {
        if ($request->has('search')) {
            $elements = $this->search($elements, $request->search);
        }

        return $elements;
    }


    public function refineData($elements, Request $request)
    {
        $elements = $this->applySearch($elements, $request);
        $elements = $this->applyFilter($elements, $request);
        return $elements;
    }
}
