<?php

namespace App\Shared\Controllers;

use App\Http\Controllers\Controller;
use App\Shared\Models\Fichier\ExtensionFichier;
use App\Shared\Models\Fichier\Fichier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BaseController extends Controller
{
    protected $model;
    protected $validation;
    protected $modelQuery;
    protected $inscription = 1;
    protected $pays = 53;

    protected $baseURL = 'http://localhost:8000/';
    protected $omittedFieldOnTableStructure = [];
    protected $defaultOmittedFieldOnTableStructure = ['id', 'created_at', 'updated_at', 'deleted_at', 'inscription'];

    public function __construct(string $model, $validation)
    {
        $this->model = $model;
        $this->validation = $validation;
        $this->modelQuery = $model::query();
    }

    public function initialise()
    {
        return $this->model::where('inscription', Auth::id())->latest()->get();
    }

    public function getAll()
    {
        return $this->model::all();
    }


    public function isValid(Request $request)
    {
        return $this->validate($request, $this->validation);
    }

    public function checkValidation(Request $request)
    {
        return Validator::make($request->all(), $this->validation);
    }

    public function latest()
    {
        return $this->model::latest()->take(4)->get();
    }


    public function index()
    {
        return $this->model::latest()->get();
    }


    public function describe()
    {
        $omittedField = array_merge($this->omittedFieldOnTableStructure, $this->defaultOmittedFieldOnTableStructure);
        $fields = DB::select('show columns from ' . (new $this->model)->getTable());
        $returnedFields = [];
        foreach ($fields as $field) {
            if (!in_array($field->Field, $omittedField)) {
                array_push($returnedFields, $field->Field);
            }
        }

        return response()->json($returnedFields, 200);
    }


    public function store(Request $request)
    {
        $this->isValid($request);
        $item = $this->model::create(array_merge($request->all(), ['inscription' => Auth::id()]));
        return $this->model::find($item->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->model::findOrFail($id);
    }

    public function download($file)
    {
        $file = Fichier::find($file);
        $contentType = null;

        if (preg_match(ExtensionFichier::getImageRegex(), $file->extension()->get()->first()->libelle)) {
            $contentType = 'image/' . $file->extension()->get()->first()->libelle;
        } elseif (preg_match(ExtensionFichier::getDocumentRegex(), $file->extension()->get()->first()->libelle)) {
            $contentType = 'application/' . $file->extension()->get()->first()->libelle;
        }
        $headers = [
            'Content-Type' => $contentType
        ];
        $fileDownload = str_replace($this->baseURL, public_path() . '/', $file->path);
        return response()->download($fileDownload, $file->name, $headers, 'inline');
    }

    // public function downloadMultiple(Request $request) {
    //     foreaupda
    // }


    public function patch(Request $request, $id)
    {
        $test = 'test';
        var_dump($test);
        $element = $this->model::findOrFail($id);
        if ($element) {
            $element->update($request->all());
            return $element->refresh();
        }

        return $this->responseError('Aucun élèment correspondant', 404);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->isvalid($request);
        $element = $this->model::find($id);
        $element->update(array_merge($request->all(), ['inscription' => Auth::id()]));
        return $this->model::find($element->id);
    }


    public function destroy($id)
    {
        $item = $this->model::find($id);
        $item->delete();
        return $item;
    }







    protected function many_to_many_update($new_array, $old_array, $affectation_model, $model_field, $foreign_field, $model_id, $inscription)
    {
        foreach ($old_array  as $item) {
            if (!in_array($item, $new_array)) {
                $element = $affectation_model::where($model_field, $model_id)->where($foreign_field, $item)->first();
                if ($element) {
                    $element->delete();
                }
            }
        }

        foreach ($new_array as $item) {
            if (!in_array($item, $old_array)) {
                $affectation = $affectation_model::create([
                    $model_field => $model_id,
                    $foreign_field => $item,
                    'inscription' => $inscription
                ]);
            }
        }
    }

    protected function many_to_many_add($array, $affectation_model, $model_field, $foreign_field, $model_id, $inscription)
    {
        foreach ($array as $item) {
            $affectation = $affectation_model::create([
                $model_field => $model_id,
                $foreign_field => $item,
                'inscription' => $inscription
            ]);
        }
    }


    protected function idExtractor($array)
    {
        $ids = [];
        foreach ($array as $item) {
            array_push($ids, $item->id);
        }

        return $ids;
    }


    protected function responseError($error_message, $status_code)
    {
        return response()->json(['error' => $error_message], $status_code);
    }


    protected function responseSuccess()
    {
        return response()->json(null, 200);
    }


    // protected function search(Request $request)
    // {
    //     $this->validate($request, [
    //         'word' => 'required',
    //         'fields' => 'required|array'
    //     ]);



    //     if (isset($request->word)) {
    //         return $this->model::latest()->get();
    //     }

    //     $elements =  $this->model::whereNull('deleted_at');
    //     foreach ($request->fields as $field) {
    //         $elements = $elements->where($field, 'like', '%' . $request->word . '%');
    //     }

    //     return $elements->get();
    // }
}
