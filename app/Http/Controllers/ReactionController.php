<?php

namespace App\Http\Controllers;

use App\Models\AffectationReactionAmbassade;
use App\Models\AffectationReactionBureau;
use App\Models\AffectationReactionConsulat;
use App\Models\AffectationReactionMinistere;
use App\Models\AffectationReactionService;
use App\Models\Discussion;
use App\Models\Reaction;
use App\Shared\Controllers\BaseController;
use App\Traits\FileHandlerTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReactionController extends BaseController
{
    use FileHandlerTrait;
    protected $model = Reaction::class;
    protected $validation = [
        'file' => 'required_without:reaction|file',
        'reaction' => 'required_without:file',
        'rebondissement' => 'nullable|integer|exists:zen_reaction,id',
        'discussion' => 'required|integer|exists:zen_discussion,id',
        'service' => 'integer|exists:zen_service,id'
    ];

    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }

    public function store(Request $request)
    {
        $request->validate($this->validation);

        $reaction =  $this->model::create([
            'reaction' => $request->reaction,
            'rebondissement' => $request->rebondissement,
            'inscription' => Auth::id(),
            'discussion' => $request->discussion
        ]);

        $discussion = Discussion::find($reaction->discussion);
        $discussion->update(['touched_at' => Carbon::now()]);


        if ($request->has('service')) {
            AffectationReactionService::create(['reaction' => $reaction->id, 'service' => $request->service, 'inscription' => Auth::id()]);
        }

        if ($request->has('ministere')) {
            AffectationReactionMinistere::create(['reaction' => $reaction->id, 'ministere' => $request->ministere, 'inscription' => Auth::id()]);
        } else if ($request->has('ambassade')) {
            AffectationReactionAmbassade::create(['reaction' => $reaction->id, 'ambassade' => $request->ambassade, 'inscription' => Auth::id()]);
        } else if ($request->has('consulat')) {
            AffectationReactionConsulat::create(['reaction' => $reaction->id, 'consulat' => $request->consulat, 'inscription' => Auth::id()]);
        } else if ($request->has('bureau')) {
            AffectationReactionBureau::create(['reaction' => $reaction->id, 'bureau' => $request->bureau, 'inscription' => Auth::id()]);
        }



        if ($request->has('file')) {
            $file = $this->storeFile($request->file, 'discussion/' . $request->discussion . '/reaction');
            $reaction->update(['file' => $file->id]);
        }

        return $this->model::find($reaction->id);
    }


    public function getByDiscussion($discussion)
    {
        return $this->model::whereHas('discussion', function ($q) use ($discussion) {
            $q->where('zen_discussion.id', $discussion);
        })->get();
    }
}
