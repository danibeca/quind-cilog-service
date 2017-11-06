<?php

namespace App\Http\Controllers\ContinuousIntegrationSystem;

use App\Http\Controllers\ApiController;
use App\Models\Component\Component;
use App\Models\Component\ComponentTree;
use App\Models\ProcessPhase\ProcessPhase;
use App\Utils\Transformers\SimpleComponentTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


class ProcessPhaseController extends ApiController
{


    public function index()
    {
        if(Input::has('component_owner_id')){
            return $this->respondData(ProcessPhase::where('component_owner_id', Input::get('component_owner_id'))->with('jobs')->get());
        }

    }
}
