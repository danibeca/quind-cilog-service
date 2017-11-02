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
        return $this->respondData(ProcessPhase::where('component_owner_id', $componentId)->with('jobs')->get());
    }

    public function store(Request $request, $id)
    {
        $phase = new ProcessPhase();
        $phase->component_owner_id = $id;
        $phase->id = $request->id;
        $phase->save();

        return $this->respondResourceCreated($phase);
    }

    public function update(Request $request, $componentId, $phaseId)
    {

        return $this->respond('OK');
    }

    public function destroy(Request $request, $componentId, $phaseId)
    {
        ProcessPhase::where('component_owner_id', $componentId)->where('id', $phaseId)->delete();

        return $this->respondResourceDeleted();
    }

}
