<?php

namespace App\Http\Controllers\Component;

use App\Http\Controllers\ApiController;
use App\Models\Component\Component;
use App\Models\Component\ComponentTree;
use App\Models\ProcessPhase\ProcessPhase;
use App\Utils\Transformers\SimpleComponentTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


class ProcessPhaseController extends ApiController
{


    public function index($componentId)
    {
        return $this->respondData(ProcessPhase::where('component_owner_id', $componentId)->get());
    }

    public function store(Request $request, $id)
    {
        $phase = new ProcessPhase();
        $phase->component_owner_id = $id;
        $phase->id = $request->id;
        $phase->save();

        return $this->respondResourceCreated($phase);
    }

    public function update(Request $request, $phaseId, $componentId)
    {

        return $this->respond('OK');
    }

    public function destroy(Request $request, $phaseId, $componentId)
    {
        ProcessPhase::where('componentId', $componentId)->where('id', $phaseId)->get()->delete();

        return $this->respondResourceDeleted();
    }

}
